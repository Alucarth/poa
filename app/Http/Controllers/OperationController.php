<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionShortTerm;
use App\Operation;
use App\Month;
use App\ProgrammaticOperation;
use Illuminate\Support\Facades\DB;
class OperationController extends Controller
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
            $operation = Operation::find($request->id);
        }else{
            $operation = new Operation;
        }
        $operation->action_short_term_id = $request->action_short_term_id;
        // $operation->programmatic_operation_id = $request->programmatic_operation_id;
        $operation->description = $request->description;
        $operation->meta = $request->meta;
        $operation->weighing = $request->weighing;
        $operation->save();
        $operation->code= 'OP-'.$operation->id;
        $operation->save();

        $operation_programmations = json_decode($request->programmatic_operations);
        // return $operation_programmations;
        $ids=array();
        foreach($operation_programmations as $operation){
            array_push($ids,$operation->programmatic_operation->id);
        }
        $operation->programmatic_operations->sync($ids);

        return $operation;
        // return $operation_programmation;

        session()->flash('message','se registro '.$operation->code);


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
        $operation = Operation::with('programmatic_operations')->find($id);
        return response()->json(compact('operation'));
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

    public function ast_operations($action_short_term_id){

        $action_short_term= ActionShortTerm::find($action_short_term_id);

        $title = 'Operaciones '. $action_short_term->code;
        return view('operation.index',compact('action_short_term','title'));
    }

    public function getProgrammaticOperations()
    {
        $programmatic_operations = ProgrammaticOperation::all();
        return $programmatic_operations;
    }

    public function check_meta($action_short_term_id){

        $total_meta = Operation::where('action_short_term_id',$action_short_term_id)
                                    ->select(DB::raw("sum(meta) as total_meta, sum(weighing) as total_ponderado"))
                                    ->groupBy('action_short_term_id')
                                    ->get();
        $action_short_term = ActionShortTerm::find($action_short_term_id);
        if(sizeof($total_meta)>0)
        {
            $meta = $action_short_term->meta - $total_meta[0]->total_meta;
            $ponderacion = 100 - $total_meta[0]->total_ponderado;
        }
        else{

            $meta = $action_short_term->meta;
            $ponderacion = 100;
        }

        return response()->json(compact('meta','ponderacion'));

    }

}
