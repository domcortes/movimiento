<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use App\Models\Planes;
use App\Models\User;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PlanesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $misPlanes = $this->getPagos(auth()->user()->id);
        $usuario = User::find(auth()->user()->id);
        return view('alumnos.planes.index', compact('misPlanes', 'usuario'));
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
        $type = 'error';
        try {
            $plan = new Planes();
            $plan->id_profesor = $request->teacher;
            $plan->numero_clases = (integer) $request->clases;
            $plan->nombre_plan = $request->nombrePlan;
            $plan->monto = (integer) $request->monto;
            $plan->estado = true;
            $plan->save();

            $type = 'success';
            $message = 'Plan creado correctamente';
        } catch (ErrorException $th) {
            $message = 'Error (general)' . $th->getMessage();
        } catch (QueryException $th) {
            $message = 'Error (query)' . $th->getMessage();
        }

        return redirect()->back()->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = false;
        $data = [];
        try {
            $data = Planes::where('id_profesor', $id)->get();
            $result = true;
            $message = 'Data catch';
        } catch (ErrorException $th) {
            $message = 'Error (general)' . $th->getMessage();
        } catch (QueryException $th) {
            $message = 'Error (query)' . $th->getMessage();
        }

        return response()->json([
            'result' => $result,
            'message' => $message,
            'data' => $data
        ]);
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

    public function getPlanFromId($id)
    {
        $result = false;
        $data = [];
        try {
            $data = Planes::where('id', $id)->get();
            $result = true;
            $message = 'Data catch';
        } catch (ErrorException $th) {
            $message = 'Error (general)' . $th->getMessage();
        } catch (QueryException $th) {
            $message = 'Error (query)' . $th->getMessage();
        }

        return response()->json([
            'result' => $result,
            'message' => $message,
            'data' => $data
        ]);
    }

    static public function getPagos($id)
    {
        $pagos = Pagos::select(
            "pagos.fecha_pago",
            "pagos.id",
            "usuario.name as nombre_usuario",
            "profesor.name as nombre_profesor",
            "pagos.fecha_inicio_mensualidad as fecha_inicio_mensualidad",
            "pagos.fecha_termino_mensualidad as fecha_termino_mensualidad",
            "pagos.cantidad_clases as cantidad_clases",
            "pagos.monto as monto",
        )
            ->join("users as usuario", "pagos.id_usuario", "=", "usuario.id")
            ->join("users as profesor", "pagos.id_profesor", "=", "profesor.id")
            ->where("usuario.id", $id)
            ->get();

        return $pagos;
    }
}
