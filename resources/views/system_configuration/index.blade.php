@extends('layouts.app')
@section('title')
    Configuracion del Sistema
@endsection
@section('breadcrums')
    {{-- {{ Breadcrumbs::render('specific_tasks',$task,$programming) }} --}}
@endsection
@section('content')

    <div class="row">
        <div class="col-md-9 justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-calendar">

                        <h3 class="card-title">
                            <h4 class="card-title ">
                                Parametros de Alerta
                                <small class="float-sm-right">
                                    {{-- <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a>  --}}
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#alertModal"  > Editar  <i class="fa fa-pen"></i> </button>
                                </small>
                            </h4>
                        </h3>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Nivel</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alerts as $alert)
                                <tr>
                                    <td>{{$alert->name}}</td>
                                    <td>
                                        <div class="progress">
                                            @switch($alert->id)
                                                @case(1)
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$alert->max}}%" aria-valuenow="{{$alert->max}}" aria-valuemin="{{$alert->min}}" aria-valuemax="100">{{$alert->min.'-'.$alert->max}}%</div>
                                                        <div class="progress-bar bg-gray-light" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                        {{-- <div class="progress-bar bg-gray-light" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div> --}}
                                                    @break

                                                @case(2)
                                                        <div class="progress-bar bg-gray-light" role="progressbar" style="width: {{$alert->min-1}}%" aria-valuenow="{{$alert->min-1}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{($alert->max+1 -$alert->min )}}%" aria-valuenow="{{$alert->max+1 -$alert->min}}" aria-valuemin="0" aria-valuemax="100">{{$alert->min.'-'.$alert->max}}%</div>
                                                        {{-- <div class="progress-bar bg-gray-light" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div> --}}
                                                    @break

                                                @case(3)
                                                        <div class="progress-bar bg-gray-light" role="progressbar" style="width: {{$alert->min}}%" aria-valuenow="{{$alert->min }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{($alert->max -$alert->min )}}%" aria-valuenow="{{$alert->max -$alert->min}}" aria-valuemin="0" aria-valuemax="100">{{$alert->min.'-'.$alert->max}}%</div>
                                                        {{-- <div class="progress-bar bg-gray-light" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div> --}}
                                                    @break

                                            @endswitch

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
	{{-- aqui los modals --}}
    {!! Form::open(['action' => 'SystemController@store']) !!}
    <!-- Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="alertModalLabel">Editar Valores de alertas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                @foreach ($alerts as $alert)
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{-- <label for="rojo">Nombre</label> --}}
                        <input type="text" class="form-control bg-{{$alert->color}}" placeholder="Nombre" value="{{$alert->name}}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            {{-- <label for="rojo">valores</label> --}}
                        <input type="text" class="form-control " name="min_{{$alert->id}}" placeholder="min" value="{{$alert->min}}">
                            {{-- <input type="text" class="form-control col-md-5" placeholder="max"> --}}
                        </div>
                        <div class="form-group col-md-3">
                            {{-- <label for="rojo">valores</label> --}}
                            <input type="text" class="form-control " name="max_{{$alert->id}}" placeholder="max" value="{{$alert->max}}">
                            {{-- <input type="text" class="form-control col-md-5" id="rojo" placeholder="max"> --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit " class="btn btn-primary">Guardar</button>
            </div>
        </div>
        </div>
    </div>
    {!! Form::close()!!}
@endsection
