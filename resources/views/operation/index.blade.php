@extends('layouts.app')
@section('title')
    Accion a Corto Plazo
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('ast_operations',$action_short_term) }}
@endsection
@section('content')

    <div class="row">
        <div class="col-md-2 col-sm-12">
            <div class="card card-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-warning">
                    <div class="row">
                        <div class="col-md-4">
                                <i class="material-icons" style="font-size:50px;">date_range</i>
                        </div>
                        <div class="col-md-8">
                            <!-- /.widget-user-image -->
                            <h3 >{{ $action_short_term->code}}</h3>
                            <h5 > <i class="material-icons">flag</i> {{ number_format($action_short_term->meta , 2, ',', '.')}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <span> <strong>Descripcion:</strong> {{$action_short_term->description}}</span>
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

        <div class="col-md-10 col-sm-12 justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-calendar">


                        <h4 class="card-title ">
                            {{$title??''}}
                            <small class="float-sm-right">
                                {{-- <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a>  --}}
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#OperationModal"  data-backdrop="static" data-keyboard="false"  data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                            </small>
                        </h4>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive-md">

                            <table id="lista" class="table table-responsive table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr >
                                        <th scope="col-1">Cod.</th>
                                        <th scope="col-6">Operacion</th>
                                        <th scope="col-1">Estructura Programatica</th>
                                        <th scope="col-1">Meta</th>
                                        <th scope="col-1">Ponderacion</th>
                                        <th scope="col-1">Ejecutado</th>
                                        <th scope="col-1">Eficacia</th>
                                        <th scope="col-1">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($action_short_term->operations as $item)
                                    <tr  >
                                        <td >{{$item->code}}</td>
                                        <td >{{$item->description}}</td>
                                        <td >{{$item->programmatic_operation->description??''}}</td>
                                        <td >{{ number_format($item->meta , 2, ',', '.')}}</td>
                                        <td >{{$item->weighing?$item->weighing.' %':'' }}</td>
                                        <td >{{$item->executed??'' }}</td>
                                        <td >{{$item->efficacy?$item->efficacy.' %':'' }}</td>
                                        <td >
                                            <a href="{{url('operation_tasks/'.$item->id)}}"><i class="material-icons text-warning">folder</i></a>
                                            <a href="#" data-toggle="modal" data-target="#OperationModal" data-backdrop="static" data-keyboard="false" data-json="{{$item}}"><i class="material-icons text-primary">edit</i></a>
                                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-json="{{$item}}"><i class="material-icons text-danger">delete</i></a>
                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- aqui los modals --}}
    <operations-component url='{{url('operations')}}' csrf='{!! csrf_field('POST') !!}' ast="{{$action_short_term}}" :operations='{{$action_short_term->programmatic_structure->programmatic_operations}}' ></operations-component>
    {{-- <indicadores-component url='{{url('action_short_term')}}' csrf='{!! csrf_field('POST') !!}' year="{{$year}}"  ></indicadores-component> --}}
     <!-- Modal -->
     {!! Form::open(['action' => 'OperationController@delete'] )!!}
     <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header bg-danger">
                     <h5 class="modal-title" id="deleteModalLabel">Eliminar la Operacion</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <span></span>
                     <input type="text" name="id">
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                     <button type="submit" class="btn btn-success">Si </button>
                 </div>
             </div>
         </div>
     </div>
     {!! Form::close()!!}
@endsection
<script>
    @section('script')
        $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var object = button.data('json');  // Extract info from data-* attributes
        console.log(object);
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Eliminar ' + object.code)
        modal.find('.modal-body span').text("Desea eliminar la operacion "+object.code+"?");
        modal.find('.modal-body input').val(object.id);
        })
    @endsection
</script>
