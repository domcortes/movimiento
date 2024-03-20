<?php

namespace App\Http\Controllers;

use App\Models\Clases;
use App\Models\Pagos;
use Illuminate\Http\Request;

class ClasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $clases = Clases::select(
            'clases.id',
            'clases.fecha',
            'users.name as nombreCreador',
            'clases.contenido as contenido',
        )
            ->join("users", "clases.id_creador", "=", "users.id")
            ->where('clases.id_pago', $id)
            ->get();

        $pago = Pagos::where('id', $id)->first();

        return view('clases.index', compact('clases', 'pago'));
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
        $clase = new Clases();
        $clase->id_pago = $id;
        $clase->id_creador = auth()->user()->id;
        $clase->fecha = $request->fechaInicio;
        $clase->contenido = $request->contenido;
        $clase->save();

        return redirect()->back()->with('success','Contenido creado correctamente');
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
