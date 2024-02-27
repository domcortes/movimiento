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
use Khipu\Configuration as KhipuConfiguration;
use Khipu\ApiClient as KhipuApiClient;
use Khipu\Client\PaymentsApi as KhipuClientPaymentsApi;
use Khipu\ApiException as KhipuApiException;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
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
        $identification = time();
        $plan = Planes::where('id', $request->plan)->first();
        $hoy = Carbon::now();

        try {
            $nuevoAlumno = new User();
            $nuevoAlumno->name = $request->user;
            $nuevoAlumno->email = $request->email;
            $nuevoAlumno->rut = 'sin rut';
            $nuevoAlumno->password = Hash::make($request->password);
            $nuevoAlumno->telefono = 'no registrado';
            $nuevoAlumno->role = 'alumno';
            $nuevoAlumno->disciplina = json_encode([]);
            $nuevoAlumno->tipo_matricula = $plan->nombre_plan;
            $nuevoAlumno->save();

            switch ($request->mode) {
                default:
                case 'khipu':


                    $receiverId = config('app.khipu_id');
                    $secretKey = config('app.khipu_key');

                    $configuration = new KhipuConfiguration();
                    $configuration->setReceiverId($receiverId);
                    $configuration->setSecret($secretKey);

                    $client = new KhipuApiClient($configuration);
                    $payments = new KhipuClientPaymentsApi($client);

                    try {
                        $opts = [
                            "transaction_id" => $identification,
                            "return_url" => route('payments.return-khipu', $identification),
                            "cancel_url" => route('payments.cancel-khipu', $identification),
                            "picture_url" => "http://mi-ecomerce.com/pictures/foto-producto.jpg",
                            "notify_url" => secure_url('/') . "/payments/notification/khipu/" . $identification,
                            "notify_api_version" => "1.3"
                        ];

                        $response = $payments->paymentsPost(
                            'Pago mensualidad de ' . $request->user . '',
                            "clp",
                            $plan->monto,
                            $opts
                        );

                        $pago = new Pagos();
                        $pago->id_usuario = $nuevoAlumno->id;
                        $pago->fecha_pago = $hoy->format('Y-m-d');
                        $pago->fecha_vencimiento = $hoy->format('Y-m-d');
                        $pago->fecha_inicio_mensualidad = $hoy->format('Y-m-d');
                        $pago->fecha_termino_mensualidad = $hoy->format('Y-m-d');
                        $pago->cantidad_clases = $plan->numero_clases;
                        $pago->medio_pago = 'e-pago';
                        $pago->primera_mensualidad = false;
                        $pago->monto = (int) $plan->monto;
                        $pago->id_profesor = $plan->id_profesor;
                        $pago->identificacion_pago = $identification;
                        $pago->plataforma = $request->mode;
                        $pago->token = $response['payment_id'];
                        $pago->save();

                        return $response['simplified_transfer_url'];
                    } catch (KhipuApiException $th) {
                        return print_r($th->getResponseBody(), true);
                    }
                    break;
            }
        } catch (ErrorException $th) {
            return $th->getMessage();
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }

    public function notificarPagoKhipu($identification)
    {
        try {
            $receiverId = config('app.khipu_id');
            $secretKey = config('app.khipu_key');
            $pagos = Pagos::where('identificacion_pago', $identification)->first();

            $configuration = new KhipuConfiguration();
            $configuration->setSecret($secretKey);
            $configuration->setReceiverId($receiverId);

            // $configuration->setDebug(true);

            $client = new KhipuApiClient($configuration);
            $payments = new KhipuClientPaymentsApi($client);

            $response = $payments->paymentsGet($identification);
            if ($response->getReceiverId() == $receiverId) {
                if ($response->getStatus() == 'done' && $response->getAmount() == $pagos->monto) {
                    error_log('done');
                    $pagos->status_pago = true;
                    $pagos->save();
                }
            } else {
                error_log('not done');
            }
        } catch (KhipuApiException $exception) {
            print_r($exception->getResponseObject());
        }
    }

    public function returnUrlKhipu($identification)
    {
        $message = 'retorno de ' . $identification;

        try {
            $receiverId = config('app.khipu_id');
            $secretKey = config('app.khipu_key');
            $pagos = Pagos::where('identificacion_pago', $identification)->first();

            $notification_token = $pagos->token; //Parámetro notification_token
            $amount = $pagos->monto;
            $api_version = '1.3';

            try {
                if ($api_version == '1.3') {
                    $configuration = new KhipuConfiguration();
                    $configuration->setSecret($secretKey);
                    $configuration->setReceiverId($receiverId);
                    // $configuration->setDebug(true);

                    $client = new KhipuApiClient($configuration);
                    $payments = new KhipuClientPaymentsApi($client);

                    $response = $payments->paymentsGet($notification_token);
                    if ($response->getReceiverId() == $receiverId) {
                        if ($response->getStatus() == 'done' && $response->getAmount() == $amount) {
                            // marcar el pago como completo y entregar el bien o servicio
                        }
                    } else {
                        // receiver_id no coincide
                    }
                } else {
                    // Usar versión anterior de la API de notificación
                }
            } catch (KhipuApiException $exception) {
                print_r($exception->getResponseObject());
            }
        } catch (KhipuApiException $exception) {
            print_r($exception->getResponseObject());
        }
    }

    public function cancelUrlKhipu($identification)
    {
        $message = 'cancelacion de ' . $identification;

        return $message;
    }
}
