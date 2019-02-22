@extends('layouts.adminlte')
@section('title')
    {{$title??'Inicio'}}
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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table id="lista" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cod. ACP</th>
                                <th>Descripcion</th>
                                {{-- <th>Resultado</th>
                                <th>Alcance</th> --}}
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $item)
                            <tr>
                                <td>{{$item->short_term_programing->codigo}}</td>
                                <td>{{$item->descripcion}}</td>
                                {{-- <td>{{$item->resultado_intermedio}}</td>
                                <td>{{$item->alcance_meta }}</td> --}}
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-dark btn-xsm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Accion
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i class="fa fa-edit"></i> Editar</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-trash"></i> Eliminar</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{url('asignar_tarea/'.$item->id)}}"> <i class="fa fa-file-o"></i> Asignar Tareas</a>
                                        </div>
                                    </div>
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