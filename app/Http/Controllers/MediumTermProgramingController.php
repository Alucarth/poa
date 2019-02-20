<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MediumTermPrograming;
class MediumTermProgramingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Programacion Mediano Plazo';
        $lista =MediumTermPrograming::all();
        return view('programing.medium_term.index',compact('title','lista'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title ='Registrar Programacion Mediano Plazo';
        return view('programing.medium_term.edit',compact('title'));
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
        $pmp = new MediumTermPrograming; //programacion a mediano plazo
        $pmp->pilar = $request->pilar;
        $pmp->meta = $request->meta;
        $pmp->resultado = $request->resultado;
        $pmp->accion = $request->accion;
        $pmp->descripcion = $request->descripcion;
        $pmp->tipo = $request->tipo;
        $pmp->resultado_intermedio = $request->resultado_intermedio;
        $pmp->linea_base = $request->linea_base;
        $pmp->indicador_resultado_intermedio = $request->indicador_resultado;
        $pmp->alcance_meta = $request->alcance_meta;
        $pmp->save();

        return redirect('programacion_medio_plazo');
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
