<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionMediumTerm;
class ActionMediumTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Acciones a Mediano Plazo';
        $lista = ActionMediumTerm::all();
        return view('action_medium_term.index',compact('title','lista'));
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
        return view('action_medium_term.edit',compact('title'));
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
        return $request->all();
        $action_medium_term = new ActionMediumTerm(); //programacion a mediano plazo
        $action_medium_term->pilar = $request->pilar;
        $action_medium_term->meta = $request->meta;
        $action_medium_term->resultado = $request->resultado;
        $action_medium_term->accion = $request->accion;
        $action_medium_term->description = $request->description;
        $action_medium_term->tipo = $request->tipo;
        $action_medium_term->resultado_intermedio = $request->resultado_intermedio;
        $action_medium_term->linea_base = $request->linea_base;
        $action_medium_term->indicador_resultado_intermedio = $request->indicador_resultado;
        $action_medium_term->alcance_meta = $request->alcance_meta;
        $action_medium_term->save();
        $action_medium_term->code='AMP-'.$action_medium_term->id;
        $action_medium_term->save();

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
    public function report_excel(){
        
        //falta corregir la hueva esta
       Excel::create('Reporte Mediano Plazo', function($excel) {

            $excel->sheet('New sheet', function($sheet) {
                
                $amps = ActionMediumTerm::all();
                $sheet->loadView('programing.medium_term.excel',compact('amps'));

            });
        
        })->download('xls');
        #

    }
}
