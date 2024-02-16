<?php

namespace App\Http\Controllers;

use App\Models\Asistencias;
use App\Models\Pagos;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $pagos = Pagos::all();
        $alumnos = User::where('role', '!=', 'profesor')->get();
        $profesores = User::where('role', 'profesor')->get();
        return view('pagos.index', compact('pagos', 'alumnos', 'profesores'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $primeraMensualidad = false;
            $pagosPrevios = Pagos::where('id_usuario', $request->alumno)->get();

            count($pagosPrevios) === 0 ?? $primeraMensualidad = true;

            $pago = new Pagos();
            $pago->id_usuario = $request->alumno;
            $pago->fecha_pago = $request->fechaPago;
            $pago->fecha_vencimiento = $request->fechaVencimiento;
            $pago->fecha_inicio_mensualidad = $request->inicioMensualidad;
            $pago->fecha_termino_mensualidad = $request->terminoMensualidad;
            $pago->cantidad_clases = $request->cantidadClases;
            $pago->medio_pago = $request->medioPago;
            $pago->primera_mensualidad = $primeraMensualidad;
            $pago->id_profesor = $request->profesor;
            $pago->save();

            return redirect()->back()->with('success', 'Mensualidad creada correctamente');
        } catch (QueryException $queryException) {
            $error = 'Error: ' . $queryException->getMessage();
            return redirect()->back()->with('warning', $error);
        } catch (\ErrorException $errorException) {
            $error = 'Error: ' . $errorException->getMessage();
            return redirect()->back()->with('warning', $error);
        }
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePayment(Request $request)
    {
        try {
            $usuario = $request->usuario;
            $pago = $request->pago;
            $asistencia = $request->asistencia;

            $checkAsistencia = Asistencias::where('id_usuario', $usuario)
                ->where('id', $asistencia)
                ->first();

            $checkAsistencia->id_pago = $pago;
            $checkAsistencia->save();

            $response = [
                'result' => true,
                'message' => 'Mensualidad actualizada correctamente',
            ];
        } catch (\ErrorException $errorException) {
            $response = [
                'response' => false,
                'message' => 'Error general: ' . $errorException->getMessage(),
            ];
        } catch (QueryException $errorException) {
            $response = [
                'response' => false,
                'message' => 'Error de DB: ' . $errorException->getMessage(),
            ];
        }

        return response()->json($response);
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
