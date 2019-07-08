<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionShortTerm;
use App\Year;
use App\Operation;
use App\Indicator;
use App\ProgrammaticStructure;
use App\ActionMediumTerm;
use Illuminate\Support\Facades\DB;
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
        if($request->has('id'))
        {
            $action_short_term = ActionShortTerm::find($request->id);
        }else
        {
            $action_short_term = new ActionShortTerm;
        }
        $action_short_term->year_id = $request->year_id;
        $action_short_term->programmatic_structure_id = $request->structure_id;
        $action_short_term->description = $request->description;
        $action_short_term->meta = $request->meta;
        $action_short_term->weighing = $request->weighing;
        $action_short_term->unidad_de_medida = $request->unidad_de_medida;
        $action_short_term->linea_base = $request->linea_base;
        $action_short_term->producto_esperado = $request->producto_esperado;
        $action_short_term->save();
        $action_short_term->code = 'ACP-'.$action_short_term->id;
        $action_short_term->save();

        session()->flash('message',' se registro '.$action_short_term->code);

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
        $action_short_term = ActionShortTerm::with('programmatic_structure')->find($id);
        return response()->json(compact('action_short_term'));
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
        return $id;
    }
    public function delete(Request $request){
        $action_short_term = ActionShortTerm::find($request->id);
        session()->flash('message',' se elimino el registro '.$action_short_term->code);
        $action_short_term->delete();
        return back()->withInput();
    }
    //adicionando logica para el flujo
    public function action_short_term_year($year_id){
        $year = Year::find($year_id);
        $lista = ActionShortTerm::with('programmatic_structure')->where('year_id',$year_id)->get();
        $title = 'Acciones a Corto Plazo '.$year->year;
        $programmatic_structures = ProgrammaticStructure::all();
        return view('action_short_term.index',compact('lista','title','year','programmatic_structures'));
    }

    public function getProgrammaticStructures()
    {
        $programmatic_structure = ProgrammaticStructure::all();
        return $programmatic_structure;
    }

    public function check_meta($year_id){

        $total_meta = ActionShortTerm::where('year_id',$year_id)
                                    ->select(DB::raw("sum(meta) as total_meta, sum(weighing) as total_ponderado"))
                                    ->groupBy('year_id')
                                    ->get();
        $year = Year::find($year_id);
        if(sizeof($total_meta)>0)
        {
            $meta = $year->meta - $total_meta[0]->total_meta;
            $ponderacion = 100 - $total_meta[0]->total_ponderado;
        }
        else{

            $meta = $year->meta;
            $ponderacion = 100;
        }

        return response()->json(compact('meta','ponderacion'));

    }
}
