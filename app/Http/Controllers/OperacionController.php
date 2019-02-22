<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortTermPrograming;
use App\MediumTermPrograming;
use App\Operacion;
class OperacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Operaciones';
        $lista = Operacion::all();
        return view('operations.index',compact('title','lista'));
        
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
        $operaciones = json_decode($request->operaciones);
        
        foreach($operaciones as $operacion){
            $op = new Operacion;
            $op->pcp_id = $request->pcp_id;
            $op->descripcion = $operacion->descripcion;
            $op->save();
        }
        return redirect('operaciones');
    }


    public function asignar_tarea($operation_id){
        $operacion = Operacion::find($operation_id);
        $title = 'Asignacion de Tareas';

        return view('operations.tasks',compact("operacion","title"));
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
       
        $pcp = ShortTermPrograming::find($id);
        $title="Operaciones";
        return view('operations.edit',compact('pmp','pcp','title'));
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
