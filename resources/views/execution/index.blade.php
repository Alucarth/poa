@extends('layouts.app')
@section('title')
    {{ $title}}
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('home') }}
@endsection
@section('content')

       <executions-component :alerts="{{$alerts}}"></executions-component>


@endsection
