<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Pagos;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asistencias = \DB::table('asistencias')
            ->join('users', 'asistencias.id_usuario','=','users.id')
            ->select(
                'users.id as idUsuario',
                'users.name as nombreUsuario',
                'asistencias.fecha_asistencia as fechaAsistencia',
                'asistencias.clase_prueba as clasePrueba',
                'asistencias.id_pago as idPago',
            )
            ->where('asistencias.id_pago','!=','null')
            ->get();

        return view('asistencias.index', compact('asistencias'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPendientes()
    {
        $pagos = Pagos::all();
        $asistencias = \DB::table('asistencias')
            ->join('users', 'asistencias.id_usuario','=','users.id')
            ->select(
                'users.id as idUsuario',
                'users.name as nombreUsuario',
                'asistencias.fecha_asistencia as fechaAsistencia',
                'asistencias.clase_prueba as clasePrueba',
                'asistencias.id_pago as idPago',
            )
            ->whereNull('asistencias.id_pago')
            ->get();

        return view('asistencias.notPaid', compact('asistencias','pagos'));
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
        try {
            $usuario = User::where('rut', $request->rut)->first();

            if($usuario !== null){
                $asistencia = new Asistencias();
                $asistencia->id_usuario = $usuario->id;
                $asistencia->id_pago = null;
                $asistencia->fecha_asistencia = $request->date;
                $asistencia->clase_prueba = false;
                $asistencia->save();

                $pagos = Pagos::where('id_usuario', $usuario->id)
                    ->where('fecha_inicio_mensualidad','<=', $request->date)
                    ->where('fecha_termino_mensualidad','>=', $request->date)
                    ->first();

                if($pagos === null){
                    $response = [
                        'result' => true,
                        'pagos' => $pagos,
                        'message' => SystemController::messagesResponse('pendientePago')
                    ];
                } else {
                    $response = [
                        'result' => true,
                        'pagos' => $pagos,
                        'message' => SystemController::messagesResponse('asistencia ok')
                    ];
                }

            } else {
                $response = [
                    'result' => false,
                    'message' => SystemController::messagesResponse('no existe alumno')
                ];
            }
        } catch (QueryException $queryException){
            $response = [
                'result' => false,
                'message' => SystemController::messagesResponse('queryException', $queryException->getMessage())
            ];
        } catch (\ErrorException $errorException){
            $response = [
                'result' => false,
                'message' => SystemController::messagesResponse('errorException', $errorException->getMessage())
            ];
        }

        return response()->json($response);
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
}
