<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores = User::whereIn('role', [
            'profesor',
            'admin'
        ])->get();
        $alumnos = User::where('role', '!=', 'profesor')->get();
        return view('profesores.index', compact('profesores', 'alumnos'));
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
            $nuevoProfesor = new User();
            $nuevoProfesor->name = $request->name;
            $nuevoProfesor->email = $request->email;
            $nuevoProfesor->rut = $request->rut;
            $nuevoProfesor->password = Hash::make($request->rut);
            $nuevoProfesor->telefono = $request->telefono;
            $nuevoProfesor->role = 'profesor';
            $nuevoProfesor->disciplina = json_encode([]);
            $nuevoProfesor->tipo_matricula = 'no aplica';
            $nuevoProfesor->save();

            $telefono = [
                $request->telefono
            ];
            SystemController::whatsappNotification('bienvenida', $telefono);

            return redirect()->back()->with('success', ucfirst($request->rol) . ' creado correctamente');
        } catch (QueryException $queryException) {
            return redirect()->back()->with('warning', 'Error al intentar guardar: ' . $queryException->getMessage());
        } catch (\ErrorException $errorException) {
            return redirect()->back()->with('warning', 'Error al error general: ' . $errorException->getMessage());
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
