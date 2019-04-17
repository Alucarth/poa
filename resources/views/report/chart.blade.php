@extends('layouts.app')
@section('title')
    Datos Estadisticos
@endsection
@section('breadcrums')
    {{-- {{ Breadcrumbs::render('action_short_term_year',$year) }} --}}
@endsection
@section('content')
<chart-component :alerts="{{$alerts}}" ></chart-component>
@endsection
