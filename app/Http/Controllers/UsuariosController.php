<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\User;
use http\Env\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumnos = User::all();
        return view('usuarios.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkRut(Request $request){
        try {
            $usuario = User::where('rut', $request->rut)->first();

            if($usuario === null){
                $response = [
                    'result' => false,
                    'message' => SystemController::messagesResponse('no existe alumno')
                ];

                return response()->json($response);
            }

            $asistenciaDiaria = Asistencias::where('fecha_asistencia', $request->date)
                ->where('id_usuario', $usuario->id)
                ->get();

            if(count($asistenciaDiaria) > 0){
                $response = [
                    'result' => false,
                    'message' => SystemController::messagesResponse('limiteAsistencia')
                ];

                return response()->json($response);
            }

            $asistencia = new Asistencias();
            $asistencia->id_usuario = $usuario->id;
            $asistencia->id_pago = null;
            $asistencia->fecha_asistencia = $request->date;
            $asistencia->clase_prueba = false;
            $asistencia->save();

            $response = [
                'result' => true,
                'message' => SystemController::messagesResponse('asistencia ok')
            ];

            return response()->json($response);
        } catch (QueryException $queryException){
            $response = [
                'result' => false,
                'message' => SystemController::messagesResponse('queryException', $queryException->getMessage())
            ];

            return response()->json($response);
        } catch (\ErrorException $errorException){
            $response = [
                'result' => false,
                'message' => SystemController::messagesResponse('errorException', $errorException->getMessage())
            ];

            return response()->json($response);
        }
    }
}
