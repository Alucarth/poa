@extends('layouts.app')
@section('title')
    Reporte
@endsection
@section('breadcrums')
    {{-- {{ Breadcrumbs::render('action_short_term_year',$year) }} --}}
@endsection
@section('content')
 <report-component></report-component>
@endsection
