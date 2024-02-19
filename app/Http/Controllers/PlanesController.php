<?php

namespace App\Http\Controllers;

use App\Models\Planes;
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
        $type = 'error';
        try {
            $plan = new Planes();
            $plan->id_profesor = $request->teacher;
            $plan->numero_clases = (integer) $request->clases;
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
}
