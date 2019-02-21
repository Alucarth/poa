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
                {{-- {!! Form::open(['action' => 'ShortTermProgramingController@store']) !!} --}}
                    <input type="text" name="pmp_id" class="form-control" value="{{$pmp->id}}" hidden>
					
                    <div class="row">
                        <div class="form-group  col-md-3">
                            {!! Form::label('codigo', 'Codigo')!!}
                            {!! Form::text('codigo',$pmp->codigo,['class'=>'form-control','readonly'])!!}
                        </div>
                        <div class="form-group  col-md-9">
                            {!! Form::label('meta', 'Accion a Corto Plazo')!!}
                            {!! Form::text('meta',$pcp->descripcion,['class'=>'form-control','readonly'])!!}
                        </div>
            
                    </div>    
                    
                    <operaciones-component></operaciones-component>

	

                </div>
                {{-- {!! Form::close() !!} --}}
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