@extends('layouts.app')
@section('title')
    Planificacion
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('action_medium_term') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header card-calendar">
                    
                    <h4 class="card-title ">
                        {{$title??''}}
                        <small class="float-sm-right">
                            <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a> 
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ActionMediumTermModal" data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                        </small>
                    </h4>
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
        <years-component url='{{url('action_medium_term')}}' csrf='{!! csrf_field('POST') !!}'></year-component>
  
         
    </div>
</div>
@endsection
@section('script')
<script>
        window.onload = function () {
            $('#lista').DataTable();
            var message =@json(session('message'));
            var error = @json(session('error'));
            var info = @json(session('info'));
            if(message){
                toastr.success(message,'Registro Exitoso');
            }
            if(error){
                toastr.error( error,'Error');
            }
            if(info){
                toastr.info(info, 'Alerta' );
            }
        };
    </script>    
@endsection