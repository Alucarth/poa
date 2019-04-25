<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionShortTerm;
use App\Operation;
use App\Month;
use App\ProgrammaticOperation;
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
        $operation->programmatic_operation_id = $request->programmatic_operation_id;
        $operation->description = $request->description;
        $operation->meta = $request->meta;
        $operation->weighing = $request->weighing;
        $operation->save();
        $operation->code= 'OP-'.$operation->id;
        $operation->save();
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

}
