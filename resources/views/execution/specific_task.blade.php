@extends('layouts.app')
@section('title')
    {{ $title}}
@endsection
@section('breadcrums')
    {{-- {{ Breadcrumbs::render('home') }} --}}
@endsection
@section('content')

    <div class="row">

          {{-- card material design --}}
        {{-- @foreach ($years as $year)

            <div class="cards col-md-3">
                <div class="mdc-card element-card wind mdc-elevation--z9">
                    <div class="mdc-card__media">
                        <h1 class="mdc-typography mdc-typography--headline4"><i class="fa fa-calendar"></i> {{$year->year}}</h1>
                        <h2 class="mdc-typography mdc-typography--subtitle2 subtitulo">  {{$year->action_medium_terms}} Acciones a Meadino Plazo </h2>
                    </div>

                    <div class="mdc-card__action-icons">
                    <a href="{{ url('execution_year/'.$year->year)}}"class="mdc-icon-button material-icons mdc-card__action mdc-card__action--icon--unbounded text-white"
                        data-mdc-ripple-is-unbounded="true" data-toggle="tooltip" data-placement="bottom" title="Abrir" >folder</a>
                    </div>
                </div>
            </div>
        @endforeach --}}

    </div>
    <execution-specific-tasks-component></execution-specific-tasks-component>

@endsection
