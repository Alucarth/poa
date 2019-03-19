<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\SpecificTask;
use Illuminate\Support\Facades\DB;
class SpecificTaskController extends Controller
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
        $specific_task = new  SpecificTask;
        $specific_task->programming_id = $request->programming_id;
        $specific_task->description = $request->description;
        $specific_task->meta = $request->meta;
        $specific_task->save();
        $specific_task->code= 'TE-'.$specific_task->id;
        $specific_task->save();
        session()->flash('message','se registro '.$specific_task->code);
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

    public function specific_task($task_id,$programming_id){
        // $task = Task::with('programmings')->where('id',$task_id)->first();
        $task = Task::find($task_id);
        $specific_tasks = SpecificTask::where('programming_id',$programming_id)->get();
        $programming = DB::table('programmings')->join('months','months.id','=','programmings.month_id')->where('programmings.id',$programming_id)->select('programmings.*','months.name')->first();
        // return json_encode($programming);
        $title ='Tareas Especificas de '.$programming->name;
        return view('specific_task.index',compact('task','specific_tasks','programming','title'));
        // $title = "Tareas de ".$operation->code;
    }
}
