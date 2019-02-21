@extends('layouts.adminlte')
@section('title')
    {{$title??''}}
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('programacion_corto_plazo') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                {{-- <div class="card-header">
                    <h3 class="card-title text-right"> <a href="{{url('programacion_medio_plazo/create')}}" class="btn btn-primary btn-sm"> Nuevo  <i class="fa fa-plus-circle"></i> </a></h3>
                </div> --}}
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
                                <th>Denomicion</th>
                                <th>Resultado</th>
                                <th>Alcance</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $item)
                            <tr>
                                <td>{{$item->codigo}}</td>
                                <td>{{$item->descripcion}}</td>
                                <td>{{$item->resultado_intermedio}}</td>
                                <td>{{$item->alcance_meta }}</td>
                                <td>
                                <a href="{{url('corto_plazo_nuevo/'.$item->id)}}"><i class="fa fa-plus-circle text-primary"></i></a>
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