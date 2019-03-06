<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionShortTerm;
use App\Year;
use App\Operation;
use App\Indicator;
class ActionShortTermController extends Controller
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
        // return $request->all();
        $action_short_term = new ActionShortTerm;
        $action_short_term->year_id = $request->year_id;
        $action_short_term->description = $request->description;
        $action_short_term->meta = $request->meta;
        $action_short_term->unidad_de_medida = $request->unidad_de_medida;
        $action_short_term->linea_base = $request->linea_base;
        $action_short_term->producto_esperado = $request->producto_esperado;
        $action_short_term->save();
        $action_short_term->code = 'ACP-'.$action_short_term->id;
        $action_short_term->save();

        session()->flash('message','se registro '.$action_short_term->code);
        // $indicadores = json_decode($request->indicadores);
        
        // foreach($indicadores as $indicador){
        //     $indicator = new Indicator;
        //     $indicator->descripcion = $indicador->descripcion;
        //     $indicator->unidad_de_medida = $indicador->unidad;
        //     $indicator->linea_base = $indicador->linea_base;
        //     $indicator->meta = $indicador->meta;
           
        //     $indicator->save();
        // }
        return back()->withInput();
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
    //adicionando logica para el flujo
    public function action_short_term_year($year_id){
        $year = Year::find($year_id);
        $lista = ActionShortTerm::where('year_id',$year_id)->get();
        $title = 'Acciones a Corto Plazo '.$year->year;
        return view('action_short_term.index',compact('lista','title','year'));
    }
}
