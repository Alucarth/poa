<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgramStructure;
use App\ProgrammaticOperation;

class ProgramaticStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $programatic_structures = ProgramStructure::all();
        // return $programatic_structures;
        return view('programmatic_structure.index',compact('programatic_structures'));
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
        $programmatic_structure= ProgramStructure::find($request->programmatic_structure_id);
        $programmatic_structure->code= $request->code;
        $programmatic_structure->description= $request->description;
        $programmatic_structure->save();
        $operations = json_decode($request->programatic_operations);
        $ids =[];
        foreach($operations as $operation)
        {
            if($operation->id>0){
                array_push($ids,$operation->id);
            }else{
                $programmatic_operation = new ProgrammaticOperation;
                $programmatic_operation->code = $operation->code;
                $programmatic_operation->programmatic_structure_id = $programmatic_structure->id;
                $programmatic_operation->description = $operation->description;
                $programmatic_operation->da = $operation->da;
                $programmatic_operation->ue = $operation->ue;
                $programmatic_operation->save();
                array_push($ids,$programmatic_operation->id);
            }
        }
        $programmatic_structure->programatic_operations()->sync($ids);
        return back()->withInput();
        // return $request->all();
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
        $programatic_structure = ProgramStructure::with('programatic_operations')->find($id);
        return response()->json($programatic_structure);
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
}
