<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Year;
use Illuminate\Support\Facades\DB;
use App\Programming;
use App\Task;
use App\Operation;
use App\ActionShortTerm;
use App\ActionMediumTerm;
use Log;
class ExecutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Inicio';
        $years = Year::select('year',DB::raw('count(action_medium_term_id) as action_medium_terms'))->groupBy('year')->orderBy('year')->get();
        // return $years;
        return view('execution.index',compact('title','years'));
        
    }

    public function specific_tasks()
    {
        $title = 'Ejecucion Tareas Especificas';
        $years = Year::select('year',DB::raw('count(action_medium_term_id) as action_medium_terms'))->groupBy('year')->orderBy('year')->get();
        // return $years;
        return view('execution.specific_task',compact('title','years'));
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
        $programming = Programming::find($request->programming_id);
        $programming->executed= $request->executed;
        $programming->efficacy= self::porcentaje($request->executed,$programming->meta) ;
        $programming->save();

        $subtotal = DB::table('programmings')->where('task_id',$programming->task_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('task_id')->get();
        
        $task = Task::find($programming->task_id);
        $task->executed= $subtotal[0]->subtotal;
        $task->efficacy= self::porcentaje($subtotal[0]->subtotal,$task->meta) ;
        $task->save();

        $subtotal = DB::table('tasks')->where('operation_id',$task->operation_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('operation_id')->get();

        $operation = Operation::find($task->operation_id);
        $operation->executed= $subtotal[0]->subtotal;
        $operation->efficacy= self::porcentaje($subtotal[0]->subtotal,$operation->meta) ;
        $operation->save();

        $subtotal = DB::table('operations')->where('action_short_term_id',$operation->action_short_term_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('action_short_term_id')->get();

        $action_short_term = ActionShortTerm::find($operation->action_short_term_id);
        $action_short_term->executed= $subtotal[0]->subtotal;
        $action_short_term->efficacy= self::porcentaje($subtotal[0]->subtotal,$action_short_term->meta) ;
        $action_short_term->save();


        $subtotal = DB::table('action_short_terms')->where('year_id',$action_short_term->year_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('year_id')->get();
        
        $year = Year::find($action_short_term->year_id);
        $year->excecuted= $subtotal[0]->subtotal;
        $year->efficacy= self::porcentaje($subtotal[0]->subtotal,$year->meta) ;
        $year->save();

        $subtotal = DB::table('years')->where('action_medium_term_id',$year->action_medium_term_id)->select(DB::raw('sum(excecuted) as subtotal'))->groupBy('action_medium_term_id')->get();
        
        $action_medium_term = ActionMediumTerm::find($year->action_medium_term_id);
        $action_medium_term->executed= $subtotal[0]->subtotal;
        $action_medium_term->efficacy= self::porcentaje($subtotal[0]->subtotal,$action_medium_term->alcance_meta) ;
        $action_medium_term->save();
        
        return response()->json(compact('programming','task','operation','action_short_term','year','action_medium_term'));

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
        $programming = Programming::find($id);        
        $task = Task::find($programming->task_id);
        $operation = Operation::find($task->operation_id);       
        $action_short_term = ActionShortTerm::find($operation->action_short_term_id);
        $year = Year::find($action_short_term->year_id);
        $action_medium_term = ActionMediumTerm::find($year->action_medium_term_id);
        
        return response()->json(compact('programming','task','operation','action_short_term','year','action_medium_term'));
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
        $programming = Programming::find($id);
        $task= Task::find($programming->task_id);
        return response()->json(compact('task','programming'));
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

    public function execution_year($year_month)
    {
        $ym = explode("-", $year_month);
        // return $ym;
        $year = $ym[0];
        $month = intval($ym[1]);
        $tasks = DB::table('years')
                ->join('action_short_terms','years.id','=','action_short_terms.year_id')
                ->join('operations','action_short_terms.id','=','operations.action_short_term_id')
                ->join('tasks','operations.id','=','tasks.operation_id')
                ->join('programmings','tasks.id','=','programmings.task_id')
                ->where('years.year','=',$year)
                ->where('programmings.month_id','=',$month)
                ->select('tasks.*','programmings.id as programming_id')
                ->get();
        return response()->json(compact('year','month','tasks'));
        // $title='Tareas';
        // return $year_id;
        // return view('execution.index',compact('title'));
    }

    public function execution_specific_task($year_month){
        $ym = explode("-", $year_month);
        // return $ym;
        $year = $ym[0];
        $month = intval($ym[1]);
        $tasks = DB::table('years')
                ->join('action_short_terms','years.id','=','action_short_terms.year_id')
                ->join('operations','action_short_terms.id','=','operations.action_short_term_id')
                ->join('tasks','operations.id','=','tasks.operation_id')
                ->join('programmings','tasks.id','=','programmings.task_id')
                ->where('years.year','=',$year)
                ->where('programmings.month_id','=',$month)
                ->select('tasks.*','programmings.id as programming_id')
                ->get();
        return response()->json(compact('year','month','tasks'));
    }


    public static  function  porcentaje( $variante, $meta ){
        return ($variante * 100)/$meta;
    }

}
