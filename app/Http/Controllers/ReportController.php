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
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing as drawing;
use App\Alert;

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

    public function chart()
    {
        $alerts = Alert::orderBy('id')->get();
        return view('report.chart',compact('alerts'));
    }

    public function years_list()
    {
        $years = DB::select('select year from years
        group by years."year"
        order by years."year";');
        return response()->json($years);
    }

    public function amt_year($month){
        $sql = 'select 	sum(programmings.executed) as month_executed,
                            sum(programmings.meta) as month_meta,
                            programmings.month_id,
                            months.name
                    from action_medium_terms
                    join years on years.action_medium_term_id = action_medium_terms.id
                    join action_short_terms on action_short_terms.year_id = years.id
                    join operations on operations.action_short_term_id = action_short_terms.id
                    join tasks on tasks.operation_id = operations.id
                    join programmings on tasks.id = programmings.task_id
                    join months on months.id = programmings.month_id
                    where years."year"='.$month.'
                    group by programmings.month_id,months.name
                    order by programmings.month_id;';
        $query = DB::select($sql);
        return response()->json($query);
    }

    public function ast_year($month)
    {
        $sql = 'select action_short_terms.*
                from action_short_terms
                join years on action_short_terms.year_id = years.id
                where years."year" = '.$month.'
                order by action_short_terms.id;';
        $query = DB::select($sql);
        return response()->json($query);
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

        $task_rows = [];
        $ma = explode(',',$request->months);
        // return $ma;
        $tasks = Task::whereHas('programmings', function ($query) use($ma) {
                                                $query->whereIn('month_id', $ma);
                                            })->get();
        // return $tasks;
        foreach($tasks as $task){

            $sql = "select 	sum(programmings.executed) as month_executed,
                            sum(programmings.meta) as month_meta,
                            programmings.month_id,
                            months.name,
                            tasks.id as task_id
                    from tasks
                    join programmings on tasks.id = programmings.task_id
                    join months on months.id = programmings.month_id
                    where programmings.month_id in (".$request->months.") and tasks.id =".$task->id."
                    group by programmings.month_id,tasks.id,months.name
                    order by tasks.id; ";
            $query = DB::select($sql);
            // return $query;
            $meses_meta = 0;
            // $meses_executed = 0;
            foreach($query as $mes){
                $meses_meta += $mes->month_meta;
                // $meses_executed += $mes->month_executed;
            }

            $pa = 0; //programacion acumuladaq
            $ea = 0; //ejecucion acumulada

            $ppa=0; //porcentaje de programaacion acumulada
            $ppe=0; //porcentaje de ejecucion acumulada
            $eea=0; //eficacia de ejecucion acumulada
            foreach($query as $mes){
                $pa += $mes->month_meta;
                $ea += $mes->month_executed;
                $ppa = self::porcentaje($pa,$meses_meta);
                $ppe = self::porcentaje($ea,$meses_meta);
                $eea = self::porcentaje($ea,$pa);

                $row = array(

                                'type_id'=> $task->id,
                                'type_code'=> $task->code,
                                'type_description'=> $task->description,
                                'name'=> $mes->name,
                                'meta'=> $mes->month_meta,
                                'executed'=>$mes->month_executed,
                                'efficacy'=> self::porcentaje($mes->month_executed,$mes->month_meta),
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                            );
                array_push($task_rows,$row);//para el pinche reporte
            }

        }

        return response()->json($task_rows);
    }
    public function report_operation(Request $request){

        $ma = explode(',',$request->months);
        $operations = Operation::join('tasks','tasks.operation_id','=','operations.id')
                                ->join('programmings','programmings.task_id','=','tasks.id')
                                ->whereIn('programmings.month_id',$ma)
                                ->select('operations.*')
                                ->groupBy('operations.id')
                                ->get();
        // return $operations;

        $operation_rows = [];
        foreach($operations as $operation){

            $sql = "
                    select 	sum(programmings.executed) as month_executed,
                    sum(programmings.meta) as month_meta,
                    programmings.month_id,
                    months.name,
                    operations.id as operation_id
                    from operations
                    join tasks on tasks.operation_id = operations.id
                    join programmings on tasks.id = programmings.task_id
                    join months on months.id = programmings.month_id
                    where programmings.month_id in (".$request->months.") and operations.id = ".$operation->id."
                    group by programmings.month_id,operations.id,months.name
                    order by operations.id;

                    ";
                $query = DB::select($sql);
                // return $query;
                $meses_meta = 0;
                // $meses_executed = 0;
                foreach($query as $mes){
                $meses_meta += $mes->month_meta;
                // $meses_executed += $mes->month_executed;
                }

                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0; //porcentaje de programaacion acumulada
                $ppe=0; //porcentaje de ejecucion acumulada
                $eea=0; //eficacia de ejecucion acumulada
                foreach($query as $mes){
                $pa += $mes->month_meta;
                $ea += $mes->month_executed;
                $ppa = self::porcentaje($pa,$meses_meta);
                $ppe = self::porcentaje($ea,$meses_meta);
                $eea = self::porcentaje($ea,$pa);

                $row = array(

                                'type_id'=> $operation->id,
                                'type_code'=> $operation->code,
                                'type_description'=> $operation->description,
                                'name'=> $mes->name,
                                'meta'=> $mes->month_meta,
                                'executed'=>$mes->month_executed,
                                'efficacy'=> self::porcentaje($mes->month_executed,$mes->month_meta),
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                            );
                array_push($operation_rows,$row);//para el pinche reporte
                }



        }//end opertaion

        //hasta aqui tareas
        return response()->json($operation_rows);
    }

    public function report_ast(Request $request){

        $ma = explode(',',$request->months);
        $action_short_terms = ActionShortTerm::join('operations','operations.action_short_term_id','=','action_short_terms.id')
                                ->join('tasks','tasks.operation_id','=','operations.id')
                                ->join('programmings','programmings.task_id','=','tasks.id')
                                ->whereIn('programmings.month_id',$ma)
                                ->select('action_short_terms.*')
                                ->groupBy('action_short_terms.id')
                                ->get();

        $action_short_term_rows =array();

        foreach($action_short_terms as $action_short_term)
        {
            $sql = "
                    select 	sum(programmings.executed) as month_executed,
                    sum(programmings.meta) as month_meta,
                    programmings.month_id,
                    months.name,
                    action_short_terms.id as action_short_terms_id
                    from action_short_terms
                    join operations on operations.action_short_term_id = action_short_terms.id
                    join tasks on tasks.operation_id = operations.id
                    join programmings on tasks.id = programmings.task_id
                    join months on months.id = programmings.month_id
                    where programmings.month_id in (".$request->months.") and action_short_terms.id = ".$action_short_term->id."
                    group by programmings.month_id,action_short_terms.id,months.name
                    order by action_short_terms.id;
                    ";
                $query = DB::select($sql);
                // return $query;
                $meses_meta = 0;
                // $meses_executed = 0;
                foreach($query as $mes){
                $meses_meta += $mes->month_meta;
                // $meses_executed += $mes->month_executed;
                }

                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0; //porcentaje de programaacion acumulada
                $ppe=0; //porcentaje de ejecucion acumulada
                $eea=0; //eficacia de ejecucion acumulada
                foreach($query as $mes){
                $pa += $mes->month_meta;
                $ea += $mes->month_executed;
                $ppa = self::porcentaje($pa,$meses_meta);
                $ppe = self::porcentaje($ea,$meses_meta);
                $eea = self::porcentaje($ea,$pa);

                $row = array(

                                'type_id'=> $action_short_term->id,
                                'type_code'=> $action_short_term->code,
                                'type_description'=> $action_short_term->description,
                                'name'=> $mes->name,
                                'meta'=> $mes->month_meta,
                                'executed'=>$mes->month_executed,
                                'efficacy'=> self::porcentaje($mes->month_executed,$mes->month_meta),
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                            );
                array_push($action_short_term_rows,$row);//para el pinche reporte
                }

        }//end action for each

        return response()->json($action_short_term_rows);
    }

    public function report_year(Request $request)
    {

        $ma = explode(',',$request->months);

        $years = Year::join('action_short_terms','action_short_terms.year_id','=','years.id')
                        ->join('operations','operations.action_short_term_id','=','action_short_terms.id')
                        ->join('tasks','tasks.operation_id','=','operations.id')
                        ->join('programmings','programmings.task_id','=','tasks.id')
                        ->whereIn('programmings.month_id',$ma)
                        ->select('years.*')
                        ->groupBy('years.id')
                        ->get();
        // return $years;
        $year_rows=array();

        foreach($years  as $year){

            $sql = "
                    select 	sum(programmings.executed) as month_executed,
                    sum(programmings.meta) as month_meta,
                    programmings.month_id,
                    months.name,
                    years.id as year_id
                    from years
                    join action_short_terms on action_short_terms.year_id = years.id
                    join operations on operations.action_short_term_id = action_short_terms.id
                    join tasks on tasks.operation_id = operations.id
                    join programmings on tasks.id = programmings.task_id
                    join months on months.id = programmings.month_id
                    where programmings.month_id in (".$request->months.") and years.id= ".$year->id."
                    group by programmings.month_id,years.id,months.name
                    order by years.id;

                    ";
                $query = DB::select($sql);
                // return $query;
                $meses_meta = 0;
                // $meses_executed = 0;
                foreach($query as $mes){
                $meses_meta += $mes->month_meta;
                // $meses_executed += $mes->month_executed;
                }

                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0; //porcentaje de programaacion acumulada
                $ppe=0; //porcentaje de ejecucion acumulada
                $eea=0; //eficacia de ejecucion acumulada
                foreach($query as $mes){
                $pa += $mes->month_meta;
                $ea += $mes->month_executed;
                $ppa = self::porcentaje($pa,$meses_meta);
                $ppe = self::porcentaje($ea,$meses_meta);
                $eea = self::porcentaje($ea,$pa);

                $row = array(

                                'type_id'=> $year->id,
                                'type_code'=> $year->year,
                                'type_description'=> $year->year,
                                'name'=> $mes->name,
                                'meta'=> $mes->month_meta,
                                'executed'=>$mes->month_executed,
                                'efficacy'=> self::porcentaje($mes->month_executed,$mes->month_meta),
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                            );
                array_push($year_rows,$row);//para el pinche reporte
                }

        }// end year

        return response()->json($year_rows);

    }

    public function report_amt(Request $request){

        $ma = explode(',',$request->months);


        $action_medium_terms = ActionMediumTerm::join('years','years.action_medium_term_id','=','action_medium_terms.id')
                        ->join('action_short_terms','action_short_terms.year_id','=','years.id')
                        ->join('operations','operations.action_short_term_id','=','action_short_terms.id')
                        ->join('tasks','tasks.operation_id','=','operations.id')
                        ->join('programmings','programmings.task_id','=','tasks.id')
                        ->whereIn('programmings.month_id',$ma)
                        ->select('action_medium_terms.*')
                        ->groupBy('action_medium_terms.id')
                        ->get();

        // return $action_medium_terms;
        $action_medium_term_rows=array();

        foreach($action_medium_terms as $action_medium_term){

            $sql = "
                    select 	sum(programmings.executed) as month_executed,
                    sum(programmings.meta) as month_meta,
                    programmings.month_id,
                    months.name,
                    action_medium_terms.id as action_medium_terms_id
                    from action_medium_terms
                    join years on years.action_medium_term_id = action_medium_terms.id
                    join action_short_terms on action_short_terms.year_id = years.id
                    join operations on operations.action_short_term_id = action_short_terms.id
                    join tasks on tasks.operation_id = operations.id
                    join programmings on tasks.id = programmings.task_id
                    join months on months.id = programmings.month_id
                    where programmings.month_id in (".$request->months.") and action_medium_terms.id=".$action_medium_term->id."
                    group by programmings.month_id,action_medium_terms.id,months.name
                    order by action_medium_terms.id;

                    ";
                $query = DB::select($sql);
                // return $query;
                $meses_meta = 0;
                // $meses_executed = 0;
                foreach($query as $mes){
                $meses_meta += $mes->month_meta;
                // $meses_executed += $mes->month_executed;
                }

                $pa = 0; //programacion acumuladaq
                $ea = 0; //ejecucion acumulada

                $ppa=0; //porcentaje de programaacion acumulada
                $ppe=0; //porcentaje de ejecucion acumulada
                $eea=0; //eficacia de ejecucion acumulada
                foreach($query as $mes){
                $pa += $mes->month_meta;
                $ea += $mes->month_executed;
                $ppa = self::porcentaje($pa,$meses_meta);
                $ppe = self::porcentaje($ea,$meses_meta);
                $eea = self::porcentaje($ea,$pa);

                $row = array(

                                'type_id'=> $action_medium_term->id,
                                'type_code'=> $action_medium_term->code,
                                'type_description'=> $action_medium_term->description,
                                'name'=> $mes->name,
                                'meta'=> $mes->month_meta,
                                'executed'=>$mes->month_executed,
                                'efficacy'=> self::porcentaje($mes->month_executed,$mes->month_meta),
                                'programacion_acumulada'=> $pa,
                                'ejecucion_acumulada'=> $ea,
                                'porcentaje_pa'=> $ppa,
                                'porcentaje_ea'=> $ppe,
                                'eficacia_ejecucion_acumulada'=>$eea

                            );
                array_push($action_medium_term_rows,$row);//para el pinche reporte
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

        // Log::info($rows);
        $title = request('title');
        $date = request('date');
        $format = request('format');
        $type = request('type');
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
        $tasks = [];
        $type_id = -1;
        $count = 0;
        $before_task=null;

        foreach($rows as $row){

            // Log::info($count);

            if($row->type_id != $type_id)
            {
                // Log::info($type_id);
                $type_id= $row->type_id;
                // if($tasks)
                //actulizando el cell merge
                $index = sizeof($tasks);
                // Log::info("index: ".$index);
                if($index >0){
                    // Log::info("cell_merge: ".json_encode($tasks[$index-1]));
                    $tasks[$index-1]->cell_merge = $count;
                }
                $count = 0;
                array_push($tasks,(object) array('description'=>$row->type_description,'cell_merge'=>$count));

            }else{

                    $count ++ ;

            }

            $before_task =$row;

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

        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
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
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('img/logo_eba.png'));
        $drawing->setHeight(80);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('A1:B6');
        $sheet->setCellValue('C3', 'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS');
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C3:I3');
        $sheet->setCellValue('C4', 'GERENCIA DE PLANIFICACIÓN Y DESARROLLO');
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C4:I4');
        $sheet->setCellValue('C5', 'REPORTE '.$title);
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C5:I5');
        $sheet->setCellValue('C6', ''.$date);
        $sheet = $spreadsheet->getActiveSheet()->mergeCells('C6:I6');
        // $sheet->getPageSetup()->setOrientation(PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C5')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('C6')->applyFromArray($styleArray);
        //dando formato a  las celdas  vacias
        $spreadsheet->getActiveSheet()->getStyle('C1:J2')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('J3:J6')->applyFromArray($styleArray);

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
            'B8'         // Top left coordinate of the worksheet range where
                        //    we want to set these values (default is A1)
        );
        $y=8;
        foreach($tasks as $task){
            // Log::info(json_encode($task));
            $sheet = $spreadsheet->getActiveSheet()->mergeCells('A'.$y.':A'.($y+$task->cell_merge));
            // Log::info($y+$task->cell_merge);
            $spreadsheet->getActiveSheet()->setCellValue('A'.$y, $task->description);
            $y+=$task->cell_merge+1;
            // Log::info($y);

        }
        // aplicando estilos
        $styleHeadArray = [
            'font' => [
                'bold' => true,
                'color' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF0d0446',
                ],
                'endColor' => [
                    'argb' => 'FF0d0446',
                ],
            ],
        ];
        $styleBodyArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF0d0446'],
                ],
            ],
        ];
        $y--;
        $spreadsheet->getActiveSheet()->getStyle('A7:J7')->applyFromArray($styleHeadArray);
        $spreadsheet->getActiveSheet()->getStyle('A8:J'.$y)->applyFromArray($styleBodyArray);
        $spreadsheet->getActiveSheet()->getStyle('A'.$y.':B'.$y)->applyFromArray($styleHeadArray);

        // unset($styleBodyArray);
        if($format =="excel"){

            $writer = new Xlsx($spreadsheet);
            $file_name ='archivoXD';
            header('Content-Type: applicaction/vnd.ms-xlsx');
            header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }else{

            $writer = new Mpdf($spreadsheet);
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
