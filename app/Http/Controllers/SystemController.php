<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Khipu\Configuration as KhipuConfiguration;
use Khipu\ApiClient as KhipuApiClient;
use Khipu\Client\PaymentsApi as KhipuClientPaymentsApi;
use Khipu\ApiException as KhipuApiException;
use Illuminate\Http\Request;

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

    public function crearPago(Request $request)
    {
        switch($request->mode){
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
                        "transaction_id" => "MTI-100",
                        "return_url" => "http://mi-ecomerce.com/backend/return",
                        "cancel_url" => "http://mi-ecomerce.com/backend/cancel",
                        "picture_url" => "http://mi-ecomerce.com/pictures/foto-producto.jpg",
                        "notify_url" => "http://mi-ecomerce.com/backend/notify",
                        "notify_api_version" => "1.3"
                    ];

                    $response = $payments->paymentsPost(
                        'Compra de prueba de api',
                        "clp",
                        100.0,
                        $opts
                    );

                    return $response['simplified_transfer_url'];
                } catch (KhipuApiException $th) {
                    echo print_r($th->getResponseBody(), true);
                }
                break;
        }
    }
}
