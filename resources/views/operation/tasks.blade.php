@extends('layouts.adminlte')
@section('title')
    {{$title??''}}
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('operaciones') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
			
                <div class="card-body">
                {!! Form::open(['action' => 'OperacionController@store_task','id'=>'form_xd']) !!}
                    <input type="text" name="operacion_id" class="form-control" value="{{$operacion->id}}" hidden>
					
                    <div class="row">
                        <div class="form-group  col-md-3">
                            {!! Form::label('codigo', 'Codigo')!!}
                            {!! Form::text('codigo',$operacion->id,['class'=>'form-control','readonly'])!!}
                        </div>
                        <div class="form-group  col-md-9">
                            {!! Form::label('descripcion', 'Accion a Corto Plazo')!!}
                            {!! Form::text('descripcion',$operacion->descripcion,['class'=>'form-control','readonly'])!!}
                        </div>
            
                    </div>    
					<tareas-component :meses={{$meses}} ></tareas-component>

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
            $('#form_xd').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
            });
        };
    </script>    
@endsection