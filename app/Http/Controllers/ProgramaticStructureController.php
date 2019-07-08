<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgrammaticStructure;
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
        $programatic_structures = ProgrammaticStructure::all();
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
        $programmatic_structure= ProgrammaticStructure::find($request->programmatic_structure_id);
        $programmatic_structure->code= $request->code;
        $programmatic_structure->description= $request->description;
        $programmatic_structure->save();
        // return $request->all();
        // return $programmatic_structure;

        $operations = json_decode($request->programmatic_operations);
        // return $request->programmatic_operations;

        //eliminando

        foreach($programmatic_structure->programmatic_operations as $item)
        {
            $find = false;

            foreach($operations as $operation)
            {
                if($operation->id > 0)
                {
                    if($item->id == $operation->id)
                    {
                        $find=true;
                    }
                }
            }
            if(!$find)
            {
                $item->delete();
            }
        }

        foreach($operations as $operation)
        {
            if($operation->id>0){
                // array_push($ids,$operation->id);
                $programmatic_operation = ProgrammaticOperation::find($operation->id);
                $programmatic_operation->code = $operation->code;
                $programmatic_operation->programmatic_structure_id = $programmatic_structure->id;
                $programmatic_operation->description = $operation->description;
                $programmatic_operation->da = $operation->da;
                $programmatic_operation->ue = $operation->ue;
                $programmatic_operation->save();
            }else{
                $programmatic_operation = new ProgrammaticOperation;
                $programmatic_operation->code = $operation->code;
                $programmatic_operation->programmatic_structure_id = $programmatic_structure->id;
                $programmatic_operation->description = $operation->description;
                $programmatic_operation->da = $operation->da;
                $programmatic_operation->ue = $operation->ue;
                $programmatic_operation->save();
                // array_push($ids,$programmatic_operation->id);
            }
        }
        // $programmatic_structure->programatic_operations()->sync($ids);
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
        $programatic_structure = ProgrammaticStructure::with('programmatic_operations')->find($id);
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
