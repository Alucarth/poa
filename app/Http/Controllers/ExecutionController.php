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
use App\SpecificTask;
use App\Alert;
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
        $alerts = Alert::orderBy('id')->get();
        // return $years;
        return view('execution.index',compact('title','years','alerts'));

    }

    public function specific_tasks()
    {
        $title = 'Ejecucion Tareas Especificas';
        $years = Year::select('year',DB::raw('count(action_medium_term_id) as action_medium_terms'))->groupBy('year')->orderBy('year')->get();
        $alerts = Alert::orderBy('id')->get();
        // return $years;
        return view('execution.specific_task',compact('title','years','alerts'));
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

    public function specific_task_store(Request $request){

        $specific_task = SpecificTask::find($request->specific_task['id']);
        $specific_task->executed= $request->specific_task['executed'];
        $specific_task->efficacy= self::porcentaje($specific_task->executed,$specific_task->meta);
        $specific_task->weighing_execution = self::ponderacion( $specific_task->efficacy, $specific_task->weighing);
        $specific_task->save();

        $subtotal = DB::table('specific_tasks')->where('programming_id',$specific_task->programming_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('programming_id')->get();

        $programming = Programming::find($specific_task->programming_id);
        $programming->executed= $subtotal[0]->subtotal;
        $programming->efficacy= self::porcentaje($subtotal[0]->subtotal,$programming->meta) ;
        // $programming->weighing_execution = self::ponderacion( $programming->efficacy, $programming->weighing);
        $programming->save();

        $subtotal = DB::table('programmings')->where('task_id',$programming->task_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('task_id')->get();

        $task = Task::find($programming->task_id);
        $task->executed= $subtotal[0]->subtotal;
        $task->efficacy= self::porcentaje($subtotal[0]->subtotal,$task->meta) ;
        $task->weighing_execution = self::ponderacion( $task->efficacy, $task->weighing);
        $task->save();

        $subtotal = DB::table('tasks')->where('operation_id',$task->operation_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('operation_id')->get();

        $operation = Operation::find($task->operation_id);
        $operation->executed= $subtotal[0]->subtotal;
        $operation->efficacy= self::porcentaje($subtotal[0]->subtotal,$operation->meta) ;
        $operation->weighing_execution = self::ponderacion( $operation->efficacy, $operation->weighing);
        $operation->save();

        $subtotal = DB::table('operations')->where('action_short_term_id',$operation->action_short_term_id)->select(DB::raw('sum(executed) as subtotal'))->groupBy('action_short_term_id')->get();

        $action_short_term = ActionShortTerm::find($operation->action_short_term_id);
        $action_short_term->executed= $subtotal[0]->subtotal;
        $action_short_term->efficacy= self::porcentaje($subtotal[0]->subtotal,$action_short_term->meta) ;
        $action_short_term->weighing_execution = self::ponderacion( $action_short_term->efficacy, $action_short_term->weighing);
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
        $action_medium_term->weighing_execution = self::ponderacion( $action_medium_term->efficacy, $action_medium_term->weighing);
        $action_medium_term->save();
        return $request->all();
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

    public function specific_task_show($specific_task_id)
    {
        $specific_task = SpecificTask::find($specific_task_id);
        $programming = Programming::find($specific_task->programming_id);
        $task = Task::find($programming->task_id);
        $operation = Operation::find($task->operation_id);
        $action_short_term = ActionShortTerm::find($operation->action_short_term_id);
        $year = Year::find($action_short_term->year_id);
        $action_medium_term = ActionMediumTerm::find($year->action_medium_term_id);

        return response()->json(compact('specific_task','programming','task','operation','action_short_term','year','action_medium_term'));
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

    public function specific_task_edit($specific_task_id){
        $specific_task = SpecificTask::find($specific_task_id);
        $programming = Programming::find($specific_task->programming_id);
        return response()->json(compact('specific_task','programming'));
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
        $specific_tasks = DB::table('years')
                ->join('action_short_terms','years.id','=','action_short_terms.year_id')
                ->join('operations','action_short_terms.id','=','operations.action_short_term_id')
                ->join('tasks','operations.id','=','tasks.operation_id')
                ->join('programmings','tasks.id','=','programmings.task_id')
                ->join('specific_tasks','specific_tasks.programming_id','=','programmings.id')
                ->where('years.year','=',$year)
                ->where('programmings.month_id','=',$month)
                ->select('specific_tasks.*','tasks.id as task_id')
                ->get();
        return response()->json(compact('year','month','specific_tasks'));
    }


    public static  function  porcentaje( $variante, $meta ){
        return ($variante * 100)/$meta;
    }

    public static function ponderacion($eficacia,$ponderacion){
        return  ($eficacia*$ponderacion)/100;
    }

}
