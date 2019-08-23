<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\SpecificTask;
use Illuminate\Support\Facades\DB;
use App\Programming;

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
        if($request->has('id')){
            $specific_task = SpecificTask::find($request->id);
        }else{
            $specific_task = new  SpecificTask;
        }
        $specific_task->programming_id = $request->programming_id;
        $specific_task->description = $request->description;
        $specific_task->meta = $request->meta;
        $specific_task->weighing = $request->weighing;
        $specific_task->code = $request->code;
        if($request->its_contribution =='true')
        {
            $specific_task->its_contribution = true;
        }else {
            $specific_task->its_contribution = false;
        }
        $specific_task->save();
        // $specific_task->code= 'TE-'.$specific_task->id;
        // $specific_task->save();

          //actualizacion de numeracion
        $specific_tasks= SpecificTask::where('id','>',$specific_task->id)->orderBy('id')->get();
        $num = $specific_task->code ;
        foreach($specific_tasks as  $specific_task){
            $num++;
            $specific_task->code = $num;
            $specific_task->save();
        }


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
        $specific_task = SpecificTask::find($id);
        return response()->json(compact('specific_task'));
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

    public function specific_task($task_id,$programming_id)
    {
        // $task = Task::with('programmings')->where('id',$task_id)->first();
        $task = Task::find($task_id);
        $specific_tasks = SpecificTask::where('programming_id',$programming_id)->get();
        $programming = DB::table('programmings')->join('months','months.id','=','programmings.month_id')->where('programmings.id',$programming_id)->select('programmings.*','months.name')->first();
        // return json_encode($programming);
        $title ='Tareas Especificas de '.$programming->name;
        return view('specific_task.index',compact('task','specific_tasks','programming','title'));
        // $title = "Tareas de ".$operation->code;
    }

    public function check_meta($programming_id)
    {

        $total_meta = SpecificTask::where('programming_id',$programming_id)
                                    ->select(DB::raw("sum(meta) as total_meta, sum(weighing) as total_ponderado"))
                                    ->where('its_contribution','=',true)
                                    ->groupBy('programming_id')
                                    ->get();
        $programming = Programming::find($programming_id);

        $total_contribution = SpecificTask::where('programming_id',$programming_id)
                            ->select(DB::raw("sum(meta) as total_meta, sum(weighing) as total_ponderado"))
                            ->groupBy('programming_id')
                            ->get();

        if(sizeof($total_meta)>0)
        {
            $meta = $programming->meta - $total_meta[0]->total_meta;
        }
        else{
            $meta = $programming->meta;
        }

        if(sizeof($total_contribution)>0)
        {
            $ponderacion = 100 - $total_contribution[0]->total_ponderado;
        }else{
            $ponderacion = 100;
        }

        return response()->json(compact('meta','ponderacion'));

    }
}
