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
                <div class="widget-user-header bg-warning">
                   
                    <div class="row">
                        <div class="col-md-4">
                                <i class="material-icons" style="font-size:40px;">date_range</i>
                        </div>
                        <div class="col-md-8">
                            <!-- /.widget-user-image -->
                            <h3 >{{ $action_short_term->code}}</h3>
                            <h5 > <i class="material-icons">flag</i> {{ $action_short_term->meta}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <span> {{$action_short_term->description}}</span>
                    </div>                    
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">

                        <li class="nav-item" >
                            <a href="{{url('ast_operations/'.$action_short_term->id)}}" class="nav-link">
                                <i class="fa fa-folder-open text-warning"></i>
                                Operaciones 
                            </a>
                        </li>
                        {{-- <li class="nav-item" >
                            <a href="{{url('ast_indicators/'.$action_short_term->id)}}" class="nav-link">
                                <i class="fa fa-folder text-warning"></i>
                                Indicadores 
                            </a>
                        </li> --}}
                        
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
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#OperationModal" data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                                </div>
                            </div>
                        </h3>
                    </div>
                    <div class="card-body">
                        
                        <table id="lista" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cod.</th>
                                    <th>Operacion</th>
                                    <th>Meta</th>
                                    <th>Ejecutado</th>
                                    <th>Eficacia</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($action_short_term->operations as $item)
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
    <operations-component url='{{url('operations')}}' csrf='{!! csrf_field('POST') !!}' ast="{{$action_short_term}}" ></operations-component>
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