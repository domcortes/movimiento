<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewStudentRequest;
use App\Models\Pagos;
use App\Models\Planes;
use App\Models\User;
use Carbon\Carbon;
use ErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus\Transaction;
use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;

class SystemController extends Controller
{
    const CODIGO_COMERCIO = '597055555532';
    const CODIGO_SECRETO = '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';

    static public function fechaFormateada($fecha)
    {
        return Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
    }

    static public function botonVerdaderoFalso($parametro)
    {
        switch ($parametro) {
            case true:
                return '<button class="btn btn-success">Prueba</button>';
            case false:
                return '<button class="btn btn-primary">Clase Regular</button>';
        }
    }

    static public function messagesResponse($tipo, $message = null)
    {
        switch ($tipo) {
            case 'no existe alumno':
                return 'Alumno no se encuentra registrado en Nataleglock o se encuentra desactivado, por favor contacta con el profesor';

            case 'asistenciaOk':
                return 'Registro de asistencia creado correctamente. Recuerda nuestras normas y disfruta tu entrenamiento';

            case 'queryException':
                return 'Error al registrar: ' . $message;

            case 'errorException':
                return 'Error general: ' . $message;

            case 'limiteAsistencia':
                return 'Usted ya registro una asistencia para el dia de hoy, contacte con el profesor';

            case 'pendientePago':
                return '<strong class="text-danger">Usted se encuentra con una mensualidad pendiente</strong><br><br>Tiene un periodo maximo de 2 clases para regularizar su mensualidad con un recargo de $5.000 por clase';
        }
    }

    public function privacidad()
    {
        return view('informaciones.privacidad');
    }

    public function reglamento()
    {
        return view('informaciones.reglamento');
    }

    static public function whatsappNotification($rut, $nombreUsuario)
    {
        try {
            $url = 'https://graph.facebook.com/v18.0/112648021891240/messages';
            $accessToken = 'EAAN7B2UHoJwBOZCeNmLTu0UTihQplu5XaAYdmPzC2jFng23ZBQi7NDzX5ETAkDeN76ZAsWINc0IOrEE04jclZC4CFWpkKHLq1lwxZCVNCdFUJrtP8JtPVi2ZAAxyoLYdpyYVd2W73lncIGqv8lSxV74hKlNZAInIXrcE0amKD0wWLxZBYvUWs0nkXhNeYwA9FXhUUQXpeCujOo8KZBAZDZD';

            $client = new Client();

            $response = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'messaging_product' => 'whatsapp',
                    'to' => 'whatsapp:56989004946',
                    'type' => 'template',
                    'template' => [
                        'name' => 'bienvenida',
                        'language' => [
                            'code' => 'en_US',
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    [
                                        'type' => 'text',
                                        'text' => $rut,
                                    ],
                                    [
                                        'type' => 'text',
                                        'text' => $nombreUsuario,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            // Manejar la respuesta aquí según tus necesidades
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            return response()->json(['statusCode' => $statusCode, 'body' => $body]);
        } catch (\ErrorException $error) {
            echo $error->getMessage();
        } catch (ClientException $error) {
            echo $error->getMessage();
        }
    }

    public function crearPago(CreateNewStudentRequest $request)
    {
        $identification = dechex(time());
        $plan = Planes::where('id', $request->plan)->first();
        $hoy = Carbon::now();

        try {


            \Transbank\Webpay\WebpayPlus::configureForIntegration(
                self::CODIGO_COMERCIO,
                self::CODIGO_SECRETO
            );

            $response = (new Transaction)->create(
                Hashids::encode($plan->id),
                $identification,
                $plan->monto,
                route('payments.respuestaTbk', $identification)
            );

            $url = $response->getUrl();
            $token = $response->getToken();

            $nuevoAlumno = new User();
            $nuevoAlumno->name = $request->user;
            $nuevoAlumno->email = $request->email;
            $nuevoAlumno->rut = 'sin rut de '.$request->user;
            $nuevoAlumno->password = Hash::make($request->password);
            $nuevoAlumno->telefono = 'no registrado';
            $nuevoAlumno->role = 'alumno';
            $nuevoAlumno->disciplina = json_encode([]);
            $nuevoAlumno->tipo_matricula = $plan->nombre_plan;
            $nuevoAlumno->hash = $identification;
            $nuevoAlumno->status = false;
            $nuevoAlumno->save();

            return response()->json([
                'result' => true,
                'form' => view('pagos.webpayForm', compact('url', 'token'))->render()
            ]);
        } catch (ErrorException | QueryException $th) {
            return response()->json([
                'result' => false,
                'form' => 'Sin procesar boton'.$th->getMessage()
            ]);
        }
    }

    public function respuestaTbk(Request $request, $identification)
    {
        $token = $request->input('token_ws') ?? null;
        if (!$token) {
            die('No es un flujo de pago normal.');
        }

        $response = (new Transaction)->commit($token);
        $authCode = $response->getAuthorizationCode();

        $usuario = User::where('hash', $identification)->first();
        $plan = Planes::where('id', Hashids::decode($response->getBuyOrder())[0])
            ->first();

        if ($response->isApproved()) {
            $hoy = Carbon::now();

            $pago = new Pagos();
            $pago->id_usuario = $usuario->id;
            $pago->fecha_pago = $hoy->format('Y-m-d');
            $pago->fecha_inicio_mensualidad = $hoy->format('Y-m-d');
            $pago->fecha_vencimiento = $hoy->addDays(30)->format('Y-m-d');
            $pago->fecha_termino_mensualidad = $hoy->addDays(30)->format('Y-m-d');
            $pago->cantidad_clases = $plan->numero_clases;
            $pago->medio_pago = 'e-pago';
            $pago->primera_mensualidad = true;
            $pago->monto = $response->getAmount();;
            $pago->id_profesor = $plan->id_profesor;
            $pago->identificacion_pago = $authCode;
            $pago->plataforma = 'webpay';
            $pago->status_pago = true;
            $pago->token = $token;
            $pago->save();

            $usuario->status = true;
            $usuario->save();

            return redirect()->route('payments.redireccionTbk', [
                $identification, $authCode
            ] );
        } else {
            $usuario->delete();
            return redirect()->route('payments.redireccionTbkFallo');
        }
    }

    public function redireccionTbk($hash, $pago){
        $usuario = User::where('hash', $hash)->first();
        $pago = Pagos::where('identificacion_pago', $pago)->first();

        dd([
            $usuario,
            $pago
        ]);
    }

    public function redireccionTbkFallo(){
        return 'pago fallo';
    }
}
