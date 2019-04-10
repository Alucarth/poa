<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Programming;
use App\Task;
use App\Operation;
use App\ActionShortTerm;
use App\Year;
use App\ActionMediumTerm;
use App\Exports\ReportExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing as drawing;

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
        $title = request('title');
        $date = request('date');
        $format = request('format');

        // 'programacion_acumulada'=> $pa,
        //             'ejecucion_acumulada'=> $ea,
        //             'porcentaje_pa'=> $ppa,
        //             'porcentaje_ea'=> $ppe,
        //             'eficacia_ejecucion_acumulada'=>$eea
        $header =[];
        foreach($columns as $column){
            array_push($header,$column->label);
        }
        $content = [];


        foreach($rows as $row){
            array_push($content,array(
                                    $row->name,
                                    $row->meta,
                                    $row->executed,
                                    $row->efficacy,
                                    $row->programacion_acumulada,
                                    $row->ejecucion_acumulada,
                                    $row->porcentaje_pa,
                                    $row->porcentaje_ea,
                                    $row->eficacia_ejecucion_acumulada,
                                    ));
        }


        $spreadsheet = new Spreadsheet();


        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            // 'borders' => [
            //     'top' => [
            //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //     ],
            // ],
            // 'fill' => [
            //     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
            //     'rotation' => 90,
            //     'startColor' => [
            //         'argb' => 'FF0000',
            //     ],
            //     'endColor' => [
            //         'argb' => 'FFFFFFFF',
            //     ],
            // ],
        ];
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('A1:B6');
        $sheet->setCellValue('C3', 'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS');
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C3:I3');
        $sheet->setCellValue('C4', 'GERENCIA DE PLANIFICIACION Y DESARROLLO');
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C4:I4');
        $sheet->setCellValue('C5', 'REPORTE '.$title);
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C5:I5');

        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C5')->applyFromArray($styleArray);

        $spreadsheet->getActiveSheet()
        ->fromArray(
            $header,  // The data to set
            NULL,        // Array values with this value will not be set
            'A7'         // Top left coordinate of the worksheet range where
                        //    we want to set these values (default is A1)
        );
        $spreadsheet->getActiveSheet()
        ->fromArray(
            $content,  // The data to set
            NULL,        // Array values with this value will not be set
            'A8'         // Top left coordinate of the worksheet range where
                        //    we want to set these values (default is A1)
        );

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('img/logo_eba.png'));
        $drawing->setHeight(80);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        if($format =="excel"){

            $writer = new Xlsx($spreadsheet);
            $file_name ='archivoXD';
            header('Content-Type: applicaction/vnd.ms-xlsx');
            header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }else{

            $writer = new Dompdf($spreadsheet);
            $file_name ='archivoXD';
            header('Content-Type: applicaction/vnd.ms-pdf');
            header('Content-Disposition: attachment;filename="'.$file_name.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }


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

    function createImageFromFile($filename, $use_include_path = false, $context = null, &$info = null)
    {
      // try to detect image informations -> info is false if image was not readable or is no php supported image format (a  check for "is_readable" or fileextension is no longer needed)
      $info = array("image"=>getimagesize($filename));
      $info["image"] = getimagesize($filename);
      if($info["image"] === false) throw new InvalidArgumentException("\"".$filename."\" is not readable or no php supported format");
      else
      {
        // fetches fileconten from url and creates an image ressource by string data
        // if file is not readable or not supportet by imagecreate FALSE will be returnes as $imageRes
        $imageRes = imagecreatefromstring(file_get_contents($filename, $use_include_path, $context));
        // export $http_response_header to have this info outside of this function
        if(isset($http_response_header)) $info["http"] = $http_response_header;
        return $imageRes;
      }
    }


    public function test(){
        // return Excel::download(new UsersExport, 'users.xls');
        // $gdImage = createImageFromFile('http://127.0.0.1:1234/dynexep/BarGen/generator.php?text=760000322300000939115260');
        $gdImage = self::createImageFromFile(public_path('img/logo_eba.png'));//call image suck re suucks

        $spreadsheet = new Spreadsheet();

        // $sheet = $spreadsheet->getActiveSheet();
        // $objDrawing = new drawing();
        // $objDrawing->setName('Sample image');
        // $objDrawing->setDescription('Sample image');
        // $objDrawing->setImageResource($gdImage);
        // $objDrawing->setRenderingFunction(drawing::RENDERING_JPEG);
        // $objDrawing->setMimeType(drawing::MIMETYPE_DEFAULT);
        // $objDrawing->setHeight(150);
        // $objDrawing->setCoordinates('A1');
        // $objDrawing->setWorksheet($sheet);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('img/logo_eba.png'));
        $drawing->setHeight(100);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        // $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        // $drawing->setName('PhpSpreadsheet logo');
        // $drawing->setPath(public_path('img/logo_eba.png'));

        // $drawing->addImage($gdImage);
        // $drawing->setHeight(100);
        // $spreadsheet->getActiveSheet()->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            // 'borders' => [
            //     'top' => [
            //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //     ],
            // ],
            // 'fill' => [
            //     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
            //     'rotation' => 90,
            //     'startColor' => [
            //         'argb' => 'FF0000',
            //     ],
            //     'endColor' => [
            //         'argb' => 'FFFFFFFF',
            //     ],
            // ],
        ];
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('A1:B6');
        $sheet->setCellValue('C3', 'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS');
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C3:I3');
        $sheet->setCellValue('C4', 'GERENCIA DE PLANIFICIACION Y DESARROLLO');
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C4:I4');
        $sheet->setCellValue('C5', 'REPORTE');
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C5:I5');

        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C5')->applyFromArray($styleArray);




        $writer = new Xlsx($spreadsheet);
        // $writer = new Dompdf($spreadsheet);


        $file_name ='archivoXD';
        header('Content-Type: applicaction/vnd.ms-xlsx');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        // $file_name ='archivoXD';
        // header('Content-Type: applicaction/vnd.ms-pdf');
        // header('Content-Disposition: attachment;filename="'.$file_name.'.pdf"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');
    }

}
