@extends('layouts.app')
@section('title')
    Operacion
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('operation_tasks',$operation) }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-2">
            <div class="card card-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-success">

                    <div class="row">
                        <div class="col-md-4">
                                <i class="material-icons" style="font-size:50px;">assignment</i>
                        </div>
                        <div class="col-md-8">
                            <!-- /.widget-user-image -->
                            <h3 >{{ $operation->code}}</h3>
                            <h5 > <i class="material-icons">flag</i> {{  number_format($operation->meta , 2, ',', '.')}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <span> <strong>Descripcion:</strong> {{$operation->description}}</span>
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

        <div class="col-md-10 justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-calendar">

                        <h3 class="card-title">
                            <h4 class="card-title ">
                                {{$title??''}}
                                <small class="float-sm-right">
                                    {{-- <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a>  --}}
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#TaskModal" data-backdrop="static" data-keyboard="false" data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                                </small>
                            </h4>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-md col-md-12">

                            <table id="task_list" class="table table-responsive table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col-1">Cod.</th>
                                        <th scope="col-6">Tareas</th>
                                        <th scope="col-1">Meta</th>
                                        <th scope="col-1">Ponderacion</th>
                                        <th scope="col-1">Ejecutado</th>
                                        <th scope="col-1">Eficacia</th>
                                        <th scope="col-1">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($operation->tasks as $item)
                                    <tr>
                                        <td>{{$item->code}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{ number_format($item->meta , 2, ',', '.') }}</td>
                                        <td>{{$item->weighing?$item->weighing.' %':'' }}</td>
                                        <td>{{$item->executed??'' }}</td>
                                        <td>{{$item->efficacy?$item->efficacy.'%':'' }}</td>
                                        <td>
                                            <a href="{{url('specific_task/'.$item->id)}}"><i class="material-icons text-warning">folder</i></a>
                                            <a href="#"><i class="material-icons text-primary" data-toggle="modal" data-target="#TaskModal" data-backdrop="static" data-keyboard="false" data-json="{{$item}}" data-programmings='{{$item->programmings}}'>edit</i></a>
                                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-json="{{$item}}"><i class="material-icons text-danger">delete</i></a>
                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                        {{-- <div id='calendar'></div> --}}
                    </div>
                </div>
            </div>
        </div>
        <tasks-component url='{{url('tasks')}}' csrf='{!! csrf_field('POST') !!}' :optask="{{$operation}}" :meses="{{$meses}}" ></operations-component>
    </div>
	{{-- aqui los modals --}}
    <!-- Modal -->
    {!! Form::open(['action' => 'TaskController@delete'] )!!}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header bg-danger">
                   <h5 class="modal-title" id="deleteModalLabel">Eliminar la Tarea</h5>
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
    $('#task_list').DataTable({
            // responsive: {
            //     details: {
            //         renderer: function ( api, rowIdx, columns ) {
            //             var data = $.map( columns, function ( col, i ) {
            //                 return col.hidden ?
            //                     '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
            //                         '<td> <strong>'+col.title+':'+'</strong> </td> '+
            //                         '<td>'+col.data+'</td>'+
            //                     '</tr>' :
            //                     '';
            //             } ).join('');
            //             return data ?
            //                 $('<table/>').append( data ) :
            //                 false;
            //         }
            //     }
            // },
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 10001, targets: 3 },
                { responsivePriority: 10002, targets: 4 },
                { responsivePriority: 10003, targets: 5 },
                { responsivePriority: 2, targets: -1 }
            ],
            language: spanish_lang

    });

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
