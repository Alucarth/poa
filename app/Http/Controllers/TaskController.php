<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Operation;
use App\Task;
use App\Month;
use App\Programming;
use App\OperationProgramming;
use Illuminate\Support\Facades\DB;
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


        // dd($programaciones) ;
        // $programmings=[];
        // foreach($programaciones as $programacion){
        //     // $programming = new Programming;
        //     // $programming->task_id = $task->id;
        //     // $programming->month_id = $programacion->id;
        //     // $programming->meta = $programacion->meta;
        //     // $programming->save();

        //     $programmings+=array(''.$programacion->id => ['meta' => $programacion->meta,'operation_programming_id'=>$programacion->operation_programming_id]);

        // }
        // dd($programmings);
        if($request->task_id!=''){
            $task = Task::find($request->task_id);
        }else{
            $task = new Task;
        }
        $task->operation_id =$request->operation_id;
        $task->description = $request->description;
        $task->meta = $request->meta;
        $task->weighing = $request->weighing;
        $task->code = $request->code;
        if($request->its_contribution =='true')
        {
            $task->its_contribution = true;
        }else {
            $task->its_contribution = false;
        }
        $task->save();

        $meses = json_decode($request->programacion);
        // return $meses;
        // first obtain object with meta > 0
        $programaciones=[];
        foreach($meses as $mes)
        {
            if($mes->meta > 0)
            {
                $programaciones[] = $mes;
            }
        }
        //eliminar los datos que no se encuentren en los casos de edicion
        $programmings = Programming::where('task_id',$task->id)->get();
        foreach($programmings as $programming)
        {
            $programming->delete();
        }
        //
        foreach($programaciones as $mes)
        {
            $programming = new Programming;
            $programming->task_id=$task->id;
            $programming->month_id = $mes->id;
            $programming->meta = $mes->meta;
            if($task->its_contribution)
            {
                $programming->operation_programming_id = $mes->operation_programming_id;
            }
            $programming->save();
        }


        // return $programaciones;


        // return $task;
        // $task->code = 'T-'.$task->id;
        // $task->save();
        // $task->programmings()->sync($programmings);


         //actualizacion de numeracion
        $tasks= Task::where('id','>',$task->id)->orderBy('id')->get();
        $num = $task->code ;
        foreach($tasks as  $task){
            $num++;
            $task->code = $num;
            $task->save();
        }

        session()->flash('message','se registro '.$task->code);
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
        $task = Task::with('programmings')->find($id);
        return response()->json(compact('task'));
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

    public function delete(Request $request)
    {
        try {
            $task = Task::find($request->id);
            $code= $task->code;
            $task->delete();
            session()->flash('message','Se elimino el registro '.$task->code);

        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error','no se pudo eliminar debido a que tiene tareas especificas.');
        }

        return back()->withInput();
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
        $operation = Operation::with('operation_programmings')->find($operation_id);
        $title = "Tareas de ".$operation->code;
        $meses = Month::all();
        return view('task.index',compact('operation','title','meses'));
    }
    public function check_meta($operation_id){


        $total_meta = Task::where('operation_id',$operation_id)
                                    ->select(DB::raw("sum(meta) as total_meta"))
                                    ->where('its_contribution','=',true)
                                    ->groupBy('operation_id')
                                    ->get();

        $total_contribution = Task::where('operation_id',$operation_id)
                                ->select(DB::raw("sum(weighing) as total_ponderado"))
                                ->groupBy('operation_id')
                                ->get();

        $operation = Operation::find($operation_id);
        if(sizeof($total_meta)>0)
        {
            $meta = $operation->meta - $total_meta[0]->total_meta;
        }
        else{

            $meta = $operation->meta;
        }
        if(sizeof($total_contribution)>0)
        {
            $ponderacion = 100 - $total_contribution[0]->total_ponderado;
        }else{
            $ponderacion = 100;
        }
        $programmings = OperationProgramming::with('month')->where('operation_id',$operation->id)->get();

        $task_programmings=[];
        foreach($programmings as $programming){

            $task_programations = Programming::where('operation_programming_id',$programming->id)->get();
            $sum_meta = 0;
            foreach($task_programations  as $task_programation)
            {
                $sum_meta += $task_programation->meta;
            }
            $programming->meta -= $sum_meta;
            array_push($task_programmings,$programming);
        }

        return response()->json(compact('meta','ponderacion','task_programmings'));

    }
}
