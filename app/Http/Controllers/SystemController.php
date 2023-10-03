<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use http\Message;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    static public function fechaFormateada($fecha){
        return Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
    }

    static public function botonVerdaderoFalso($parametro)
    {
        switch ($parametro){
            case true:
                return '<button class="btn btn-success">Prueba</button>';
            case false:
                return '<button class="btn btn-primary">Clase Regular</button>';
        }
    }

    static public function messagesResponse($tipo, $message = null){
        switch ($tipo){
            case 'no existe alumno':
                return 'Alumno no se encuentra registrado en Nataleglock o se encuentra desactivado, por favor contacta con el profesor';

            case 'asistenciaOk':
                return 'Registro de asistencia creado correctamente. Recuerda nuestras normas y disfruta tu entrenamiento';

            case 'queryException':
                return 'Error al registrar: '.$message;

            case 'errorException':
                return 'Error general: '.$message;

            case 'limiteAsistencia':
                return 'Usted ya registro una asistencia para el dia de hoy, contacte con el profesor';

            case 'pendientePago':
                return '<strong class="text-danger">Usted se encuentra con una mensualidad pendiente</strong><br><br>Tiene un periodo maximo de 2 clases para regularizar su mensualidad con un recargo de $5.000 por clase';

        }
    }

    public function privacidad(){
        return view('informaciones.privacidad');
    }

    static public function whatsappNotification($tipo, $telefonos = []){
        try {
            $url = 'https://graph.facebook.com/v17.0/112648021891240/messages';
            $token = 'EAAN7B2UHoJwBAMtOmn8TuREfRB97OlZCy2qgM2BmgrWLs0BZBa5ZCfGc7xKZC5lQe5GXHi3WOAA20keGDZBs2SXmPFLf09FqMhhGfESBDhKOvrgW4pitex9wJQoAXUU8c98ZC1LCtdLsCurRwTAfIXi336kAMTkZCCreRWrbWJtfUJlgwUZAj7ge7ZBpIlQZCQ0bfY9AlEi2dYqgx13SvDBedS';

            foreach ($telefonos as $telefono){
                switch ($tipo){
                    case 'bienvenida':
                        $mensaje =''
                            .'{'
                            .'"messaging_product": "whatsapp", '
                            .'"to": "'.$telefono.'", '
                            .'"type": "template",'
                            .'"template": '
                            .'{'
                            .'  "name": "bienvenida",'
                            .'  "language":{ "code": "en_US" },'
                            .'} '
                            .'}';
                        break;
                }

                $header = [
                    'Authorization: Bearer '.$token,
                    "Content-Type: application/json",
                ];

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);

                $response = json_decode(curl_exec($curl), true);
                print_r($response);

                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
            }


        } catch (\ErrorException $error){
            echo $error->getMessage();
        }
    }
}
