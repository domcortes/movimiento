<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos = Pagos::all();
        $alumnos = User::all();
        return view('pagos.index', compact('pagos', 'alumnos'));
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
            $pago->save();

            return redirect()->back()->with('success', 'Mensualidad creada correctamente');
        } catch (QueryException $queryException){
            $error = 'Error: '.$queryException->getMessage();
            return redirect()->back()->with('warning', $error);
        } catch (\ErrorException $errorException){
            $error = 'Error: '.$errorException->getMessage();
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
