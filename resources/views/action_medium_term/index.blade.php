@extends('layouts.app')
@section('title')
    {{$title??'Inicio'}}
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('programacion_medio_plazo') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header">
                 {{-- @include('action_medium_term.edit') --}}
                    <h3 class="card-title text-right">
                        <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a> 
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ActionMediumTermModal" data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                    </h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table id="lista" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cod.</th>
                                <th>Accion Mediano Plazo</th>
                                <th>Resultado</th>
                                <th>Meta</th>
                                <th>Ejecutado</th>
                                <th>Eficacia</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $item)
                            <tr>
                                <td>{{$item->code}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->resultado_intermedio}}</td>
                                <td>{{$item->alcance_meta }}</td>
                                <td>{{$item->executed??'' }}</td>
                                <td>{{$item->efficacy?$item->efficacy.'%':'' }}</td>
                                <td>
                                    <a href="{{url('action_short_term_year/'.$item->years[0]->id)}}"><i class="material-icons text-warning">folder</i></a>
                                    <a href="#"><i class="material-icons text-primary">edit</i></a>
                                    <a href="#"><i class="material-icons text-danger">delete</i></a>
                                </td>
                                
                            </tr>
                                
                            @endforeach
                            
                        </tbody>
                        
                    </table>
                            {{-- <div id='calendar'></div> --}}
                </div>
            </div>
        </div>

        {{-- aqui los modals --}}
        <div class="modal fade" id="ActionMediumTermModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                {!! Form::open(['action' => 'ActionMediumTermController@store']) !!}
                <div class="modal-content">
                    <div class="modal-header laravel-modal-bg">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
    
                        <legend>Estructura del POES</legend>    
                        <div class="row">
                            <div class="form-group  col-md-3">
                                {!! Form::label('pilar', 'Pilar')!!}
                                {!! Form::number('pilar','',['class'=>'form-control','placeholder'=>'Pilar'])!!}
                            </div>
                            <div class="form-group  col-md-3">
                                {!! Form::label('meta', 'Meta')!!}
                                {!! Form::number('meta','',['class'=>'form-control','placeholder'=>'Meta'])!!}
                            </div>
                            <div class="form-group  col-md-3">
                                {!! Form::label('resultado', 'Resultado')!!}
                                {!! Form::number('resultado','',['class'=>'form-control','placeholder'=>'Resultado'])!!}
                            </div>
                            <div class="form-group  col-md-3">
                                {!! Form::label('accion', 'Accion')!!}
                                {!! Form::number('accion','',['class'=>'form-control','placeholder'=>'Accion'])!!}
                            </div>
                        </div>    
                        <legend>Accion de Mediano Plazo del PEE</legend>
                        <div class="row">
                            <div class="form-group  col-md-12">
                                {!! Form::label('descripcion', 'Descripcion')!!}
                                {!! Form::text('descripcion','',['class'=>'form-control','placeholder'=>'Descripcion'])!!}
                            </div>
                            <div class="form-group  col-md-4">
                                {!! Form::label('tipo', 'Tipo')!!}
                                {!! Form::select('tipo', ['Proceso' => 'Proceso', 'Apoyo' => 'Apoyo'],null,['class'=>'form-control'])!!}
                            </div>
                            <div class="form-group  col-md-8">
                                {!! Form::label('resultado_intermedio', 'Resultado Intermedio')!!}
                                {!! Form::text('resultado_intermedio','',['class'=>'form-control','placeholder'=>'Resultado Intermedio'])!!}
                            </div>
                            <div class="form-group  col-md-6">
                                {!! Form::label('linea_base', 'Linea Base')!!}
                                {!! Form::text('linea_base','',['class'=>'form-control','placeholder'=>'Linea Base'])!!}
                            </div>
                            <div class="form-group  col-md-6">
                                {!! Form::label('indicador_resultado', 'Indicador de Resultado')!!}
                                {!! Form::text('indicador_resultado','',['class'=>'form-control','placeholder'=>' Indicador de Resultado'])!!}
                            </div>
                            <div class="form-group  col-md-6">
                                {!! Form::label('alcance_meta', 'Alcance de Meta')!!}
                                {!! Form::number('alcance_meta','',['class'=>'form-control','placeholder'=>'Alcance de Meta','step'=>'any'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
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
            $('#lista').DataTable();
            $('#ActionMediumTermModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var amt = button.data('json') // Extract info from data-* attributes
                var title ='Nueva Accion a Mediano Plazo';
                if(amt)
                {
                    title='Editar '+amt.code;
                }
                console.log(amt);
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-title').text(title)
                modal.find('.modal-body input').val(amt)
            })
        };
    </script>    
@endsection