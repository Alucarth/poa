<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortTermPrograming;
use App\MediumTermPrograming;
use App\PcpIndicator;
class ShortTermProgramingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Programacion Corto Plazo';
        $lista = ShortTermPrograming::all();
        // return $lista;
        return view('programing.short_term.index',compact('title','lista'));
        
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
        $pcp = new ShortTermPrograming;
        $pcp->pmp_id = $request->pmp_id;
        $pcp->descripcion = $request->descripcion;
        $pcp->save();
        $pcp->codigo ="ACP-".$pcp->id;
        $pcp->save();

        $indicadores = json_decode($request->indicadores);
        
        foreach($indicadores as $indicador){
            $pcp_indicator = new PcpIndicator;
            $pcp_indicator->descripcion = $indicador->descripcion;
            $pcp_indicator->unidad_de_medida = $indicador->unidad;
            $pcp_indicator->linea_base = $indicador->linea_base;
            $pcp_indicator->meta = $indicador->meta;
            $pcp_indicator->producto_esperado = $indicador->producto_esperado;
            $pcp_indicator->save();
        }
   
        return redirect('programacion_corto_plazo');
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
    public function createPCP($id)
    {
        $pmp = MediumTermPrograming::find($id);
        $title = 'Programacion Corto Plazo';
        return view('programing.short_term.create_pcp',compact('pmp','title'));
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
