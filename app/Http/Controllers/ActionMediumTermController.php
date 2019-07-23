<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionMediumTerm;
use App\Year;
use App\ProgrammaticStructure;
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
        $lista = ActionMediumTerm::with('programmatic_structure')->orderBy('code')->get();
        $ponderacion = 0;
        foreach($lista as $asm)
        {
            if($asm->tipo =="Proceso"){
                $ponderacion += $asm->weighing;
            }
        }
        if($ponderacion > 100){
            session()->flash('error','Se sobrepaso el 100% de la ponderacion estimada en accion a mediano plazo ');
        }
        $programmatic_structures = ProgrammaticStructure::all();
        // return $programmatic_structures;
        return view('action_medium_term.index',compact('title','lista','programmatic_structures'));
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
        // return $request->all();
        if($request->has('id')){
           $action_medium_term = ActionMediumTerm::find($request->id);
        }else{
            $action_medium_term = new ActionMediumTerm(); //programacion a mediano plazo
        }
        $action_medium_term->programmatic_structure_id = $request->programmatic_structure_id;
        $action_medium_term->pilar = $request->pilar;
        $action_medium_term->meta = $request->meta;
        $action_medium_term->resultado = $request->resultado;
        $action_medium_term->accion = $request->accion;
        $action_medium_term->description = $request->description;
        $action_medium_term->tipo = $request->tipo;
        $action_medium_term->clasificacion = $request->clasificacion;
        $action_medium_term->resultado_intermedio = $request->resultado_intermedio;
        $action_medium_term->linea_base = $request->linea_base;
        $action_medium_term->indicador_resultado_intermedio = $request->indicador_resultado_intermedio;
        $action_medium_term->alcance_meta = $request->alcance_meta;
        $action_medium_term->weighing = $request->weighing;
        $action_medium_term->code = $request->code;
        $action_medium_term->save();

        $gestiones = json_decode($request->gestiones);
        //
        foreach($gestiones as $gestion){
            if(isset($gestion->id)){
                $year = Year::find($gestion->id);
            }else{
                $year = new Year;
            }
            $year->action_medium_term_id = $action_medium_term->id;
            $year->year = $gestion->year;
            $year->meta = $gestion->meta;
            $year->save();

        }
        //actualizacion de numeracion
        $amts= ActionMediumTerm::where('id','>',$action_medium_term->id)->orderBy('id')->get();
        $num = $action_medium_term->code ;
        foreach($amts as  $amt){
            $num++;
            $amt->code = $num;
            $amt->save();
        }



        session()->flash('message','se registro '.$action_medium_term->code);

        return redirect('action_medium_term');
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
        $action_medium_term = ActionMediumTerm::with('programmatic_structure')->find($id);

        return response()->json(compact('action_medium_term'));
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
        $action_medium_term = ActionMediumTerm::find($id);
        $code =$action_medium_term->code;
        foreach($action_medium_term->years as $year){
            $year->delete();
        }

        // $action_medium_term->years->delete();
        $action_medium_term->delete();
        session()->flash('delete','se elimino el registro '.$code);
        return $id;
    }
    public function delete(Request $request)
    {
        $action_medium_term = ActionMediumTerm::find($request->id);
        $code =$action_medium_term->code;
        foreach($action_medium_term->years as $year){
            $year->delete();
        }

        // $action_medium_term->years->delete();
        $action_medium_term->delete();
        session()->flash('delete','se elimino el registro '.$code);
        return back()->withInput();
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
    public function last_amt(){
        $amt = ActionMediumTerm::orderBy('id','DESC')->first();
        return response()->json($amt);
    }
}
