<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\SpecificTask;
use Illuminate\Support\Facades\DB;
use App\Programming;
use App\SpecificTaskProgrammation;
use Log;
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
        // return $request->all();
        if($request->has('id')){
            $specific_task = SpecificTask::find($request->id);
        }else{
            $specific_task = new  SpecificTask;
        }
        $specific_task->task_id = $request->task_id;
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

        $specific_programmings = json_decode($request->specific_programmings);
        // return $specific_programmings;

        foreach($specific_programmings  as $specific_programming)
        {
            // return json_encode($specific_programming);
            if($specific_programming->meta > 0)
            {

                if(isset($specific_programming->id))
                {
                    Log::info("id specific_programming = ".$specific_programming->id);
                    $sp_programming = SpecificTaskProgrammation::find($specific_programming->id);
                    Log::info($sp_programming);
                }else
                {
                    $sp_programming = new SpecificTaskProgrammation;
                    Log::info('creando una nueva tarea especifica');
                }
                $sp_programming->programming_id = $specific_programming->programming_id;
                $sp_programming->specific_task_id = $specific_task->id;
                $sp_programming->meta = $specific_programming->meta;
                $sp_programming->save();
            }else
            {
                if(isset($specific_programming->id))
                {
                    Log::info(" borrando id specific_programming = ".$specific_programming->id);
                    $sp_programming = SpecificTaskProgrammation::find($specific_programming->id);
                    $sp_programming->delete();
                    Log::info("se elimino registro");
                }
            }

            // return $sp_programming;
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
        $specific_task_programmation = SpecificTaskProgrammation::with('programming')->where('specific_task_id',$specific_task->id)->get();
        // $specific_task->$specific_task_programmation = $specific_task_programmation ;
        return response()->json(compact('specific_task','specific_task_programmation'));
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
    public function delete(Request $request)
    {
        $specific_task = SpecificTask::find($request->id);
        $specific_task_programmations = SpecificTaskProgrammation::where('specific_task_id',$specific_task->id)->get();
        foreach($specific_task_programmations as $specific_task_programmation)
        {
            $specific_task_programmation->delete();
        }
        session()->flash('message',' Se elimino el registro '.$specific_task->code);
        $specific_task->delete();
        return back()->withInput();
    }

    public function specific_task($task_id)
    {

        $task = Task::with('programmings')->find($task_id);
        $specific_tasks = SpecificTask::where('task_id',$task->id)->get();

        $title ='Tareas Especificas ';
        return view('specific_task.index',compact('task','specific_tasks','title'));

    }

    public function check_meta($task_id)
    {

        $total_meta = SpecificTask::where('task_id',$task_id)
                                    ->select(DB::raw("sum(meta) as total_meta, sum(weighing) as total_ponderado"))
                                    ->where('its_contribution','=',true)
                                    ->groupBy('task_id')
                                    ->get();
        // return $total_meta;

        $task = Task::find($task_id);
        $total_contribution = SpecificTask::where('task_id',$task_id)
                            ->select(DB::raw("sum(meta) as total_meta, sum(weighing) as total_ponderado"))
                            ->groupBy('task_id')
                            ->get();

        if(sizeof($total_meta)>0)
        {
            $meta = $task->meta - $total_meta[0]->total_meta;
        }
        else{
            $meta = $task->meta;
        }

        if(sizeof($total_contribution)>0)
        {
            $ponderacion = 100 - $total_contribution[0]->total_ponderado;
        }else{
            $ponderacion = 100;
        }

        $programmings = Programming::with('month')->where('task_id',$task->id)->get();
        $specific_programmings= [];
        foreach($programmings as $programming)
        {
            $specific_task_programmations = SpecificTaskProgrammation::with('programming')
                                                                    ->where('programming_id',$programming->id)
                                                                    ->get();
            $sum_meta = 0;

            foreach($specific_task_programmations as $specific_task_programmation )
            {
                $sum_meta+= $specific_task_programmation->meta;
                // array_push();
            }
            $programming->meta -= $sum_meta;
            array_push($specific_programmings,$programming);
        }


        return response()->json(compact('meta','ponderacion','specific_programmings'));

    }
}
