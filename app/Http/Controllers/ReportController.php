<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Programming;
use App\Task;
use App\Operation;
use App\ActionShortTerm;
use App\Year;
use App\ActionMediumTerm;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('report.index');
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
        $sql= "
        select 	sum(programmings.executed) as month_executed,
		sum(programmings.meta) as month_meta,
		programmings.month_id
        from action_medium_terms
        join years on years.action_medium_term_id = action_medium_terms.id
        join action_short_terms on action_short_terms.year_id = years.id
        join operations on operations.action_short_term_id = action_short_terms.id
        join tasks on tasks.operation_id = operations.id
        join programmings on programmings.task_id = tasks.id
        join specific_tasks on specific_tasks.programming_id = programmings.id
        where years.year ='".$request->year."' and programmings.month_id in(".$request->months.")
        group by programmings.month_id";
        $query = DB::select($sql);

        return response()->json($query);
    }

    public function report_task(Request $request){
        // $programmings = Programming::whereIn('month_id',$request->months)->get();
        $tasks = Task::whereHas('programmings', function ($query) use($request) {
                                                $query->whereIn('month_id', $request->months);
                                            })->get();
        $task_rows=array();


        $total_executed =0;
        $total_meta =0;
        foreach($tasks as $task){


            $pa = 0; //programacion acumuladaq
            $ea = 0; //ejecucion acumulada

            $ppa=0;
            $ppe=0;
            $eea=0;

            $programmings =Programming::where('task_id',$task->id)->whereIn('month_id',$request->months)->orderBy('month_id')->get();
            $periodo_meta = 0;
            $periodo_executed = 0;
            foreach($programmings as $programming){
                $periodo_meta += $programming->meta;
                $periodo_executed += $programming->executed;
            }
            $total_executed +=$periodo_executed;
            $total_meta +=$periodo_meta;
            foreach($programmings as $programming){

                $pa += $programming->meta;
                $ea += $programming->executed;
                // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada
                // $eea = ($ea/$pa)*100; //eficacia de ejecucion acumulada
                $row = array(
                                'name'=> $task->code.' '.$programming->month->name,
                                'meta'=> $programming->meta,
                                'executed'=>$programming->executed,
                                'efficacy'=>$programming->efficacy,
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                            );
                array_push($task_rows,$row);
            }


        }



        return response()->json($task_rows);
    }
    public function report_operation(Request $request){

        $operations = Operation::all();

        $operation_rows =array();

        foreach($operations as $operation){

            $tasks = Task::whereHas('programmings', function ($query) use($request) {
                                $query->whereIn('month_id', $request->months);
                            })
                            ->where('operation_id',$operation->id)
                            ->get();
            $task_rows=array();


            $total_executed =0;
            $total_meta =0;

            foreach($tasks as $task){


                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0;
                $ppe=0;
                $eea=0;

                $programmings =Programming::where('task_id',$task->id)->whereIn('month_id',$request->months)->orderBy('month_id')->get();
                $periodo_meta = 0;
                $periodo_executed = 0;

                foreach($programmings as $programming){
                    $periodo_meta += $programming->meta;
                    $periodo_executed += $programming->executed;
                }

                $total_executed +=$periodo_executed;
                $total_meta +=$periodo_meta;

                foreach($programmings as $programming){

                    $pa += $programming->meta;
                    $ea += $programming->executed;
                    // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                    // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                    $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                    $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                    $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada
                    // $eea = ($ea/$pa)*100; //eficacia de ejecucion acumulada
                    $row = array(
                    'name'=> $task->code.' '.$programming->month->name,
                    'meta'=> $programming->meta,
                    'executed'=>$programming->executed,
                    'efficacy'=>$programming->efficacy,
                    'programacion_acumulada'=> $pa,
                    'ejecucion_acumulada'=> $ea,
                    'porcentaje_pa'=> $ppa,
                    'porcentaje_ea'=> $ppe,
                    'eficacia_ejecucion_acumulada'=>$eea

                    );
                    array_push($task_rows,$row);
                }

            } //end task

            $pa = 0; //programacion acumuladaq
            $ea = 0; //ejecucion acumulada

            $ppa=0;
            $ppe=0;
            $eea=0;

            $periodo_meta = 0;
            $periodo_executed = 0;
            // Log::info($task_rows);

            foreach($task_rows as $task_array){
                $task = (object) $task_array;
                $periodo_meta += $task->meta;
                $periodo_executed += $task->executed;
            }

            foreach($task_rows as $task_array){

                $task = (object) $task_array;

                $pa += $task->meta;
                $ea += $task->executed;
                // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                $row = array(
                    'name'=> $operation->code.' '.$task->name,
                    'meta'=> $task->meta,
                    'executed'=>$task->executed,
                    'efficacy'=>$task->efficacy,
                    'programacion_acumulada'=> $pa,
                    'ejecucion_acumulada'=> $ea,
                    'porcentaje_pa'=> $ppa,
                    'porcentaje_ea'=> $ppe,
                    'eficacia_ejecucion_acumulada'=>$eea

                );

                array_push($operation_rows,$row);
            }




        }//end opertaion




        //hasta aqui tareas
        return response()->json($operation_rows);
    }

    public function report_ast(Request $request){

        $action_short_terms = ActionShortTerm::all();
        $action_short_term_rows =array();

        foreach($action_short_terms as $action_short_term)
        {

            $operation_rows =array();

            foreach($action_short_term->operations as $operation){

                $tasks = Task::whereHas('programmings', function ($query) use($request) {
                                    $query->whereIn('month_id', $request->months);
                                })
                                ->where('operation_id',$operation->id)
                                ->get();
                $task_rows=array();


                $total_executed =0;
                $total_meta =0;

                foreach($tasks as $task){


                    $pa = 0; //programacion acumuladaq
                    $ea = 0; //ejecucion acumulada

                    $ppa=0;
                    $ppe=0;
                    $eea=0;

                    $programmings =Programming::where('task_id',$task->id)->whereIn('month_id',$request->months)->orderBy('month_id')->get();
                    $periodo_meta = 0;
                    $periodo_executed = 0;

                    foreach($programmings as $programming){
                        $periodo_meta += $programming->meta;
                        $periodo_executed += $programming->executed;
                    }

                    $total_executed +=$periodo_executed;
                    $total_meta +=$periodo_meta;

                    foreach($programmings as $programming){

                        $pa += $programming->meta;
                        $ea += $programming->executed;
                        // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                        // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                        $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                        $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                        $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada
                        // $eea = ($ea/$pa)*100; //eficacia de ejecucion acumulada
                        $row = array(
                        'name'=> $task->code.' '.$programming->month->name,
                        'meta'=> $programming->meta,
                        'executed'=>$programming->executed,
                        'efficacy'=>$programming->efficacy,
                        'programacion_acumulada'=> $pa,
                        'ejecucion_acumulada'=> $ea,
                        'porcentaje_pa'=> $ppa,
                        'porcentaje_ea'=> $ppe,
                        'eficacia_ejecucion_acumulada'=>$eea

                        );
                        array_push($task_rows,$row);
                    }

                } //end task

                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0;
                $ppe=0;
                $eea=0;

                $periodo_meta = 0;
                $periodo_executed = 0;
                // Log::info($task_rows);

                foreach($task_rows as $task_array){
                    $task = (object) $task_array;
                    $periodo_meta += $task->meta;
                    $periodo_executed += $task->executed;
                }

                foreach($task_rows as $task_array){

                    $task = (object) $task_array;

                    $pa += $task->meta;
                    $ea += $task->executed;
                    // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                    // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                    $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                    $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                    $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                    $row = array(
                        'name'=> $operation->code.' '.$task->name,
                        'meta'=> $task->meta,
                        'executed'=>$task->executed,
                        'efficacy'=>$task->efficacy,
                        'programacion_acumulada'=> $pa,
                        'ejecucion_acumulada'=> $ea,
                        'porcentaje_pa'=> $ppa,
                        'porcentaje_ea'=> $ppe,
                        'eficacia_ejecucion_acumulada'=>$eea

                    );

                    array_push($operation_rows,$row);
                }


            }//end opertaion

            $pa = 0; //programacion acumuladaq
            $ea = 0; //ejecucion acumulada

            $ppa=0;
            $ppe=0;
            $eea=0;

            $periodo_meta = 0;
            $periodo_executed = 0;
            // Log::info($task_rows);

            foreach($operation_rows as $operation_array){
                $operation = (object) $operation_array;
                $periodo_meta += $operation->meta;
                $periodo_executed += $operation->executed;
            }

            foreach($operation_rows as $operation_array){

                $operation = (object) $operation_array;

                $pa += $operation->meta;
                $ea += $operation->executed;
                // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                $row = array(
                    'name'=> $action_short_term->code.' '.$operation->name,
                    'meta'=> $operation->meta,
                    'executed'=>$operation->executed,
                    'efficacy'=>$operation->efficacy,
                    'programacion_acumulada'=> $pa,
                    'ejecucion_acumulada'=> $ea,
                    'porcentaje_pa'=> $ppa,
                    'porcentaje_ea'=> $ppe,
                    'eficacia_ejecucion_acumulada'=>$eea

                );

                array_push($action_short_term_rows,$row);
            }


        }//end action for each

        return response()->json($action_short_term_rows);
    }

    public function report_year(Request $request)
    {
        $years = Year::all();
        $year_rows=array();

        foreach($years  as $year){

            $action_short_term_rows =array();

            foreach($year->action_short_terms as $action_short_term)
            {

                $operation_rows =array();

                foreach($action_short_term->operations as $operation){

                    $tasks = Task::whereHas('programmings', function ($query) use($request) {
                                        $query->whereIn('month_id', $request->months);
                                    })
                                    ->where('operation_id',$operation->id)
                                    ->get();
                    $task_rows=array();


                    $total_executed =0;
                    $total_meta =0;

                    foreach($tasks as $task){


                        $pa = 0; //programacion acumuladaq
                        $ea = 0; //ejecucion acumulada

                        $ppa=0;
                        $ppe=0;
                        $eea=0;

                        $programmings =Programming::where('task_id',$task->id)->whereIn('month_id',$request->months)->orderBy('month_id')->get();
                        $periodo_meta = 0;
                        $periodo_executed = 0;

                        foreach($programmings as $programming){
                            $periodo_meta += $programming->meta;
                            $periodo_executed += $programming->executed;
                        }

                        $total_executed +=$periodo_executed;
                        $total_meta +=$periodo_meta;

                        foreach($programmings as $programming){

                            $pa += $programming->meta;
                            $ea += $programming->executed;
                            // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                            // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                            $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                            $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                            $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada
                            // $eea = ($ea/$pa)*100; //eficacia de ejecucion acumulada
                            $row = array(
                            'name'=> $task->code.' '.$programming->month->name,
                            'meta'=> $programming->meta,
                            'executed'=>$programming->executed,
                            'efficacy'=>$programming->efficacy,
                            'programacion_acumulada'=> $pa,
                            'ejecucion_acumulada'=> $ea,
                            'porcentaje_pa'=> $ppa,
                            'porcentaje_ea'=> $ppe,
                            'eficacia_ejecucion_acumulada'=>$eea

                            );
                            array_push($task_rows,$row);
                        }

                    } //end task

                    $pa = 0; //programacion acumuladaq
                    $ea = 0; //ejecucion acumulada

                    $ppa=0;
                    $ppe=0;
                    $eea=0;

                    $periodo_meta = 0;
                    $periodo_executed = 0;
                    // Log::info($task_rows);

                    foreach($task_rows as $task_array){
                        $task = (object) $task_array;
                        $periodo_meta += $task->meta;
                        $periodo_executed += $task->executed;
                    }

                    foreach($task_rows as $task_array){

                        $task = (object) $task_array;

                        $pa += $task->meta;
                        $ea += $task->executed;
                        // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                        // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                        $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                        $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                        $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                        $row = array(
                            'name'=> $operation->code.' '.$task->name,
                            'meta'=> $task->meta,
                            'executed'=>$task->executed,
                            'efficacy'=>$task->efficacy,
                            'programacion_acumulada'=> $pa,
                            'ejecucion_acumulada'=> $ea,
                            'porcentaje_pa'=> $ppa,
                            'porcentaje_ea'=> $ppe,
                            'eficacia_ejecucion_acumulada'=>$eea

                        );

                        array_push($operation_rows,$row);
                    }


                }//end opertaion

                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0;
                $ppe=0;
                $eea=0;

                $periodo_meta = 0;
                $periodo_executed = 0;
                // Log::info($task_rows);

                foreach($operation_rows as $operation_array){
                    $operation = (object) $operation_array;
                    $periodo_meta += $operation->meta;
                    $periodo_executed += $operation->executed;
                }

                foreach($operation_rows as $operation_array){

                    $operation = (object) $operation_array;

                    $pa += $operation->meta;
                    $ea += $operation->executed;
                    // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                    // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                    $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                    $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                    $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                    $row = array(
                        'name'=> $action_short_term->code.' '.$operation->name,
                        'meta'=> $operation->meta,
                        'executed'=>$operation->executed,
                        'efficacy'=>$operation->efficacy,
                        'programacion_acumulada'=> $pa,
                        'ejecucion_acumulada'=> $ea,
                        'porcentaje_pa'=> $ppa,
                        'porcentaje_ea'=> $ppe,
                        'eficacia_ejecucion_acumulada'=>$eea

                    );

                    array_push($action_short_term_rows,$row);
                }


            }//end action for each


            $pa = 0; //programacion acumuladaq
            $ea = 0; //ejecucion acumulada

            $ppa=0;
            $ppe=0;
            $eea=0;

            $periodo_meta = 0;
            $periodo_executed = 0;
            // Log::info($task_rows);

            foreach($action_short_term_rows as $action_short_term_array){
                $action_short_term = (object) $action_short_term_array;
                $periodo_meta += $action_short_term->meta;
                $periodo_executed += $action_short_term->executed;
            }

            foreach($action_short_term_rows as $action_short_term_array){

                $action_short_term = (object) $action_short_term_array;

                $pa += $action_short_term->meta;
                $ea += $action_short_term->executed;
                // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                $row = array(
                    'name'=> $year->year.' '.$action_short_term->name,
                    'meta'=> $action_short_term->meta,
                    'executed'=>$action_short_term->executed,
                    'efficacy'=>$action_short_term->efficacy,
                    'programacion_acumulada'=> $pa,
                    'ejecucion_acumulada'=> $ea,
                    'porcentaje_pa'=> $ppa,
                    'porcentaje_ea'=> $ppe,
                    'eficacia_ejecucion_acumulada'=>$eea

                );

                array_push($year_rows,$row);
            }

        }// end year

        return response()->json($year_rows);

    }

    public function report_amt(Request $request){

        $action_medium_terms = ActionMediumTerm::all();
        $action_medium_term_rows=array();

        foreach($action_medium_terms as $action_medium_term){

            $year_rows=array();

            foreach($action_medium_term->years  as $year){

                $action_short_term_rows =array();

                foreach($year->action_short_terms as $action_short_term)
                {

                    $operation_rows =array();

                    foreach($action_short_term->operations as $operation){

                        $tasks = Task::whereHas('programmings', function ($query) use($request) {
                                            $query->whereIn('month_id', $request->months);
                                        })
                                        ->where('operation_id',$operation->id)
                                        ->get();
                        $task_rows=array();


                        $total_executed =0;
                        $total_meta =0;

                        foreach($tasks as $task){


                            $pa = 0; //programacion acumuladaq
                            $ea = 0; //ejecucion acumulada

                            $ppa=0;
                            $ppe=0;
                            $eea=0;

                            $programmings =Programming::where('task_id',$task->id)->whereIn('month_id',$request->months)->orderBy('month_id')->get();
                            $periodo_meta = 0;
                            $periodo_executed = 0;

                            foreach($programmings as $programming){
                                $periodo_meta += $programming->meta;
                                $periodo_executed += $programming->executed;
                            }

                            $total_executed +=$periodo_executed;
                            $total_meta +=$periodo_meta;

                            foreach($programmings as $programming){

                                $pa += $programming->meta;
                                $ea += $programming->executed;
                                // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                                // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                                $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                                $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                                $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada
                                // $eea = ($ea/$pa)*100; //eficacia de ejecucion acumulada
                                $row = array(
                                'name'=> $task->code.' '.$programming->month->name,
                                'meta'=> $programming->meta,
                                'executed'=>$programming->executed,
                                'efficacy'=>$programming->efficacy,
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                                );
                                array_push($task_rows,$row);
                            }

                        } //end task

                        $pa = 0; //programacion acumuladaq
                        $ea = 0; //ejecucion acumulada

                        $ppa=0;
                        $ppe=0;
                        $eea=0;

                        $periodo_meta = 0;
                        $periodo_executed = 0;
                        // Log::info($task_rows);

                        foreach($task_rows as $task_array){
                            $task = (object) $task_array;
                            $periodo_meta += $task->meta;
                            $periodo_executed += $task->executed;
                        }

                        foreach($task_rows as $task_array){

                            $task = (object) $task_array;

                            $pa += $task->meta;
                            $ea += $task->executed;
                            // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                            // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                            $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                            $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                            $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                            $row = array(
                                'name'=> $operation->code.' '.$task->name,
                                'meta'=> $task->meta,
                                'executed'=>$task->executed,
                                'efficacy'=>$task->efficacy,
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                            );

                            array_push($operation_rows,$row);
                        }


                    }//end opertaion

                    $pa = 0; //programacion acumuladaq
                    $ea = 0; //ejecucion acumulada

                    $ppa=0;
                    $ppe=0;
                    $eea=0;

                    $periodo_meta = 0;
                    $periodo_executed = 0;
                    // Log::info($task_rows);

                    foreach($operation_rows as $operation_array){
                        $operation = (object) $operation_array;
                        $periodo_meta += $operation->meta;
                        $periodo_executed += $operation->executed;
                    }

                    foreach($operation_rows as $operation_array){

                        $operation = (object) $operation_array;

                        $pa += $operation->meta;
                        $ea += $operation->executed;
                        // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                        // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                        $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                        $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                        $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                        $row = array(
                            'name'=> $action_short_term->code.' '.$operation->name,
                            'meta'=> $operation->meta,
                            'executed'=>$operation->executed,
                            'efficacy'=>$operation->efficacy,
                            'programacion_acumulada'=> $pa,
                            'ejecucion_acumulada'=> $ea,
                            'porcentaje_pa'=> $ppa,
                            'porcentaje_ea'=> $ppe,
                            'eficacia_ejecucion_acumulada'=>$eea

                        );

                        array_push($action_short_term_rows,$row);
                    }


                }//end action for each


                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0;
                $ppe=0;
                $eea=0;

                $periodo_meta = 0;
                $periodo_executed = 0;
                // Log::info($task_rows);

                foreach($action_short_term_rows as $action_short_term_array){
                    $action_short_term = (object) $action_short_term_array;
                    $periodo_meta += $action_short_term->meta;
                    $periodo_executed += $action_short_term->executed;
                }

                foreach($action_short_term_rows as $action_short_term_array){

                    $action_short_term = (object) $action_short_term_array;

                    $pa += $action_short_term->meta;
                    $ea += $action_short_term->executed;
                    // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                    // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                    $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                    $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                    $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                    $row = array(
                        'name'=> $year->year.' '.$action_short_term->name,
                        'meta'=> $action_short_term->meta,
                        'executed'=>$action_short_term->executed,
                        'efficacy'=>$action_short_term->efficacy,
                        'programacion_acumulada'=> $pa,
                        'ejecucion_acumulada'=> $ea,
                        'porcentaje_pa'=> $ppa,
                        'porcentaje_ea'=> $ppe,
                        'eficacia_ejecucion_acumulada'=>$eea

                    );

                    array_push($year_rows,$row);
                }

            }// end year

            $pa = 0; //programacion acumuladaq
            $ea = 0; //ejecucion acumulada

            $ppa=0;
            $ppe=0;
            $eea=0;

            $periodo_meta = 0;
            $periodo_executed = 0;
            // Log::info($task_rows);

            foreach($year_rows as $year_array){
                $year = (object) $year_array;
                $periodo_meta += $year->meta;
                $periodo_executed += $year->executed;
            }

            foreach($year_rows as $year_array){

                $year = (object) $year_array;

                $pa += $year->meta;
                $ea += $year->executed;
                // $ppa = ($pa/$periodo_meta)*100; //porcentaje  programaciion acumulado
                // $ppe = ($ea/$periodo_meta)*100; //porcentaje  efcicacia acumulada
                $ppa = self::porcentaje($pa,$periodo_meta); //porcentaje  programaciion acumulado
                $ppe = self::porcentaje($ea,$periodo_meta); //porcentaje  efcicacia acumulada
                $eea = self::porcentaje($ea,$pa); //eficacia de ejecucion acumulada

                $row = array(
                    'name'=> $action_medium_term->code.' '.$year->name,
                    'meta'=> $year->meta,
                    'executed'=>$year->executed,
                    'efficacy'=>$year->efficacy,
                    'programacion_acumulada'=> $pa,
                    'ejecucion_acumulada'=> $ea,
                    'porcentaje_pa'=> $ppa,
                    'porcentaje_ea'=> $ppe,
                    'eficacia_ejecucion_acumulada'=>$eea

                );

                array_push($action_medium_term_rows,$row);
            }
        }//end short tearm each

        return response()->json($action_medium_term_rows);
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

    public function report_excel(){


        $columns =json_decode(request('columns'));
        $rows =json_decode(request('rows'));
        // // Log::info(request('columns'));
        // return $columns;
        $data = compact('columns','rows');
        // $data = array("columns"=>$columns,"rows"=>$rows);
        Log::info($data);
       Excel::create('Reporte Mensual', function($excel) use($data)  {

            $excel->sheet('New sheet', function($sheet) use($data) {

                // $amps = ActionMediumTerm::all();
                $sheet->loadView('report.excel',$data);

            });

        })->download('xls');
        // return request()->all();
    }

    public function report_pdf(){


        $columns =json_decode(request('columns'));
        $rows =json_decode(request('rows'));
        // // Log::info(request('columns'));
        // return $columns;
        $data = compact('columns','rows');
        // $data = array("columns"=>$columns,"rows"=>$rows);
        Log::info($data);
       Excel::create('Reporte Mensual', function($excel) use($data)  {

            $excel->sheet('New sheet', function($sheet) use($data) {

                // $amps = ActionMediumTerm::all();
                $sheet->loadView('report.excel',$data);

            });

        })->export('pdf');
        // return request()->all();
    }

    public static  function  porcentaje( $variante, $meta ){
        try {
            return ($variante * 100)/$meta;
            //code...
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
