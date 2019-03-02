<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Operation;
use App\Task;
use App\Month;
use App\Programming;
class TaskController extends Controller
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
        $programaciones = json_decode($request->programacion);
        // dd($programaciones) ;
        $programmings=[];
        foreach($programaciones as $programacion){
            // $programming = new Programming;
            // $programming->task_id = $task->id;
            // $programming->month_id = $programacion->id;
            // $programming->meta = $programacion->meta;
            // $programming->save();
           
            $programmings+=array(''.$programacion->id => ['meta' => $programacion->meta]);
       
        }
        // dd($programmings);
        if($request->task_id!=''){
            $task = Task::find($request->task_id);
        }else{
            $task = new Task;
        }
        $task->operation_id =$request->operation_id;
        $task->description = $request->description;
        $task->meta = $request->meta;
        $task->save();
        $task->code = 'T-'.$task->id;
        $task->save();
        $task->programmings()->sync($programmings);
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

    public function operation_tasks($operation_id)
    {
        $operation = Operation::find($operation_id);
        $title = "Tareas de ".$operation->code;
        $meses = Month::all();
        return view('task.index',compact('operation','title','meses'));
    }
}
