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

    static public function messagesResponse($tipo, $message = null){
        switch ($tipo){
            case 'no existe alumno':
                return 'Alumno no se encuentra registrado en Nataleglock, por favor contacta con el profesor';

            case 'asistencia ok':
                return 'Registro de asistencia creado correctamente';

            case 'queryException':
                return 'Error al registrar: '.$message;

            case 'errorException':
                return 'Error general: '.$message;

            case 'limiteAsistencia':
                return 'Usted ya registro una asistencia para el dia de hoy, contacte con el profesor';

        }
    }
}
