@extends('layouts.adminlte')
@section('title')
    {{$title??''}}
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('programacion_medio_plazo_nuevo') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body">
                {!! Form::open(['action' => 'MediumTermProgramingController@store']) !!}
                    <legend>Estructura del POES</legend>    
                    <div class="row">
                        <div class="form-group  col-md-3">
                            {!! Form::label('pilar', 'Pilar')!!}
                            {!! Form::text('pilar','Pilar',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-3">
                            {!! Form::label('meta', 'Meta')!!}
                            {!! Form::text('meta','Meta',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-3">
                            {!! Form::label('resultado', 'Resultado')!!}
                            {!! Form::text('resultado','Resultado',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-3">
                            {!! Form::label('accion', 'Accion')!!}
                            {!! Form::text('accion','Accion',['class'=>'form-control'])!!}
                        </div>
                    </div>    
                    <legend>Accion de Mediano Plazo del PEE</legend>
                    <div class="row">
                        <div class="form-group  col-md-10">
                            {!! Form::label('descripcion', 'Descripcion')!!}
                            {!! Form::text('descripcion','Descripcion',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-4">
                            {!! Form::label('tipo', 'Tipo')!!}
                            {!! Form::select('tipo', ['Proceso' => 'Proceso', 'Apoyo' => 'Apoyo'],null,['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('resultado_intermedio', 'Resultado Intermedio')!!}
                            {!! Form::text('resultado_intermedio','Resultado Intermedio',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('linea_base', 'Linea Base')!!}
                            {!! Form::text('linea_base','Linea Base',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('indicador_resultado', 'Indicador de Resultado')!!}
                            {!! Form::text('indicador_resultado','Indicador de Resultado',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('alcance_meta', 'Alcance de Meta')!!}
                            {!! Form::text('alcance_meta','Alcance de Meta',['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="p-2 ">
                                <a href="#" class="btn btn-danger">Cancelar</a>
                            </div>
                            <div class="p-2">
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                    {{-- <div id='calendar'></div> --}}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
        window.onload = function () {
            // $('#lista').DataTable();
            // $('#calendar').fullCalendar({
            //     weekends: false // will hide Saturdays and Sundays
            // });
        };
    </script>    
@endsection