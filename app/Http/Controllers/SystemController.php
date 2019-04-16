<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alert;
class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $alerts = Alert::orderBy('id')->get();
        return view('system_configuration.index',compact('alerts'));

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
        $rojo = Alert::find(1);
        $rojo->min = $request->min_1;
        $rojo->max = $request->max_1;
        $rojo->save();
        $amarillo = Alert::find(2);
        $amarillo->min = $request->min_2;
        $amarillo->max = $request->max_2;
        $amarillo->save();
        $verde = Alert::find(3);
        $verde->min = $request->min_3;
        $verde->max = $request->max_3;
        $verde->save();
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
