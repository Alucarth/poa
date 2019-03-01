@extends('layouts.app')
@section('title')
    
@endsection
@section('breadcrums')
    {{-- {{ Breadcrumbs::render('programacion_medio_plazo') }} --}}
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-success">
                   
                    <div class="row">
                        <div class="col-md-4">
                                <i class="material-icons" style="font-size:40px;">assignment</i>
                        </div>
                        <div class="col-md-8">
                            <!-- /.widget-user-image -->
                            <h3 >{{ $operation->code}}</h3>
                            <h5 > <i class="material-icons">flag</i> {{ $operation->meta}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <span> {{$operation->description}}</span>
                    </div>                    
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">

                        <li class="nav-item" >
                            <a href="{{url('operation_tasks/'.$operation->id)}}" class="nav-link">
                                <i class="fa fa-folder-open text-success"></i>
                                Tareas 
                            </a>
                        </li>
                
                        
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9 justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                            
                        <h3 class="card-title">
                            <div class="row">
                                <div class="col-md-5">
                                    {{$title??''}}
                                </div>   
                                {{-- <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a> --}}
                                <div class=" col-md-7 text-right">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#TaskModal" data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                                </div>
                            </div>
                        </h3>
                    </div>
                    <div class="card-body">
                        
                        <table id="lista" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cod.</th>
                                    <th>Tareas</th>
                                    <th>Meta</th>
                                    <th>Ejecutado</th>
                                    <th>Eficacia</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($operation->tasks as $item)
                                <tr>
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->meta }}</td>
                                    <td>{{$item->executed??'' }}</td>
                                    <td>{{$item->efficacy?$item->efficacy.'%':'' }}</td>
                                    <td>
                                        <a href="{{url('operation_tasks/'.$item->id)}}"><i class="material-icons text-warning">folder</i></a>
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
        </div>
    </div>
	{{-- aqui los modals --}}
	
	<tasks-component url='{{url('tasks')}}' csrf='{!! csrf_field('POST') !!}' optask="{{$operation}}" :meses="{{$meses}}" ></operations-component>
    {{-- <indicadores-component url='{{url('action_short_term')}}' csrf='{!! csrf_field('POST') !!}' year="{{$year}}"  ></indicadores-component> --}}
</div>
@endsection
@section('script')
<script>
        window.onload = function () {
            $('#lista').DataTable();
            // $('#calendar').fullCalendar({
            //     weekends: false // will hide Saturdays and Sundays
            // });
        };
    </script>    
@endsection