<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Programming;
use App\Task;
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
        $rows=array();


        $total_executed =0;
        $total_meta =0;
        foreach($tasks as $task){


            $pa = 0; //programacion acumuladaq
            $ea = 0; //ejecucion acumulada

            $ppa=0;
            $pea=0;
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
                array_push($rows,$row);
            }


        }

        // $row = array(
        //                 'name'=> 'Periodo',
        //                 'meta'=> $total_meta,
        //                 'executed'=>$total_executed,
        //                 'efficacy'=> self::porcentaje($total_executed,$total_meta),
        //                 'programacion_acumulada'=> 0,
        //                 'ejecucion_acumulada'=> 0,
        //                 'porcentaje_pa'=> 0,
        //                 'porcentaje_ea'=> 0,
        //                 'eficacia_ejecucion_acumulada'=>0

        //             );
        // array_push($rows,$row);


        return response()->json($rows);
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
