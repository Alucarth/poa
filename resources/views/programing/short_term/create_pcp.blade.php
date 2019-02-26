@extends('layouts.adminlte')
@section('title')
    {{$title??''}}
@endsection
@section('breadcrums')
    {{-- {{ Breadcrumbs::render('programacion_corto_plazo_nuevo') }} --}}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
			
                <div class="card-body">
                {!! Form::open(['action' => 'ShortTermProgramingController@store']) !!}
                    <input type="text" name="programacion_medio_plazo_id" class="form-control" value="{{$pmp->id}}" hidden>
					<legend>Accion de Mediano Plazo</legend>
                    <div class="row">
                        <div class="form-group  col-md-3">
                            {!! Form::label('codigo', 'Codigo')!!}
                            {!! Form::text('codigo',$pmp->codigo,['class'=>'form-control','readonly'])!!}
                        </div>
                        <div class="form-group  col-md-9">
                            {!! Form::label('meta', 'Accion MP')!!}
                            {!! Form::text('meta',$pmp->descripcion,['class'=>'form-control','readonly'])!!}
                        </div>
            
                    </div>    
                    <legend>Accion de Corto Plazo </legend>
                    <div class="row">
                        <div class="form-group  col-md-10">
                            {!! Form::label('descripcion', 'Descripcion')!!}
                            {!! Form::text('descripcion','',['class'=>'form-control','placeholder'=>'Descripcion'])!!}
                        </div>
					</div>
					
                    <indicadores-component></indicadores-component>

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