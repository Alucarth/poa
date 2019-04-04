<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
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

}
