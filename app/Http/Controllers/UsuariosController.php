<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Pagos;
use App\Models\User;
use http\Env\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

            $response = [
                'result' => true,
                'message' => '¿Deseas marcar tu asistencia?'
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

    public function crearAsistencia(Request $request){
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

            $pagos = Pagos::where('id_usuario', $usuario->id)
                ->where('fecha_inicio_mensualidad','<=', $request->date)
                ->where('fecha_termino_mensualidad','>=', $request->date)
                ->first();

            $asistencia = new Asistencias();
            $asistencia->id_usuario = $usuario->id;
            $asistencia->fecha_asistencia = $request->date;
            $asistencia->clase_prueba = false;
            $asistencia->created_at = $request->dateTime;
            $asistencia->updated_at = $request->dateTime;


            if($pagos === null){
                $asistencia->id_pago = null;
                $asistencia->save();
                $response = [
                    'result' => true,
                    'pagos' => $pagos,
                    'message' => SystemController::messagesResponse('pendientePago')
                ];


                return response()->json($response);
            } else {
                $asistencia->id_pago = $pagos->id;
                $asistencia->save();

                $response = [
                    'result' => true,
                    'pagos' => $pagos,
                    'message' => SystemController::messagesResponse('asistenciaOk')
                ];


                return response()->json($response);
            }


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

    public function createUser(Request $request){
        try {
            $alumnoNuevo = new User();
            $alumnoNuevo->name = $request->name;
            $alumnoNuevo->email = $request->email;
            $alumnoNuevo->rut = $request->rut;
            $alumnoNuevo->password = Hash::make($request->rut);
            $alumnoNuevo->telefono = $request->telefono;
            $alumnoNuevo->role = $request->rol;
            $alumnoNuevo->disciplina = json_encode($request->deporte);
            $alumnoNuevo->save();

            $telefono = [
                $request->telefono
            ];
            SystemController::whatsappNotification('bienvenida', $telefono);

            return redirect()->back()->with('success', ucfirst($request->rol).' creado correctamente');
        } catch (QueryException $queryException){
            return redirect()->back()->with('warning', 'Error al intentar guardar: '.$queryException->getMessage());
        } catch (\ErrorException $errorException){
            return redirect()->back()->with('warning', 'Error al error general: '.$errorException->getMessage());
        }
    }

    public function revisarDeportes(Request $request){
        $idAlumno = $request->alumno;
        $nogi = 0;
        $jiujitsu = 0;
        $mma = 0;

        $alumno = User::where('id', $idAlumno)->first();

        if(in_array('nogi', json_decode($alumno->disciplina))){
            $nogi = 8;
        }

        if(in_array('jiujitsu', json_decode($alumno->disciplina))){
            $jiujitsu = 12;
        }

        if(in_array('mma', json_decode($alumno->disciplina))){
            $mma = 12;
        }

        $clases = $nogi + $jiujitsu + $mma;

        return response()->json([
            'response' => true,
            'clases' => $clases
        ]);
    }
}
