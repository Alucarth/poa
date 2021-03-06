@extends('layouts.app')
@section('title')
    Planificacion
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('action_medium_term') }}
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header card-calendar">

                    <h4 class="card-title ">
                        {{$title??''}}
                        <small class="float-sm-right">
                            {{-- <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a>  --}}
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ActionMediumTermModal" data-backdrop="static" data-keyboard="false" data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                        </small>
                    </h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-responsive-md">

                        <table id="lista" class="table table-responsive table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th>Nº</th> --}}
                                    <th scope="col-1">Cod.</th>
                                    <th scope="col-5">Accion Mediano Plazo</th>
                                    <th scope="col-1">Resultado</th>
                                    <th scope="col-1">Meta</th>
                                    <th scope="col-1">Ponderacion</th>
                                    <th scope="col-1">Ejecutado</th>
                                    <th scope="col-1">Eficacia</th>
                                    <th scope="col-1">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lista as $item)
                                <tr>
                                    {{-- <td>{{$item->id}}</td> --}}
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->resultado_intermedio}}</td>
                                    <td>{{ number_format($item->alcance_meta , 2, ',', '.')}}</td>
                                    <td>{{$item->weighing }}</td>
                                    <td>{{$item->executed??'' }}</td>
                                    <td>{{$item->efficacy?$item->efficacy.'%':'' }}</td>
                                    <td>
                                        <a href="{{url('action_short_term_year/'.$item->year()->id)}}"><i class="material-icons text-warning">folder</i></a>
                                        <a href="#" data-toggle="modal" data-target="#ActionMediumTermModal" data-backdrop="static" data-keyboard="false" data-json="{{$item}}"><i class="material-icons text-primary">edit</i></a>
                                        {{-- <a href="#"> <i class="material-icons text-danger deleted" data-json='{{$item}}'>delete</i></a> --}}
                                        <a href="#" data-toggle="modal" data-target="#deleteModal" data-backdrop="static" data-keyboard="false" data-json="{{$item}}"><i class="material-icons text-danger">delete</i></a>
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

        {{-- aqui los modals --}}
    <years-component url='{{url('action_medium_term')}}' csrf='{!! csrf_field('POST') !!}' :structures="{{$programmatic_structures}}  " ></year-component>


    </div>
    <!-- Modal -->
    {!! Form::open(['action' => 'ActionMediumTermController@delete'] )!!}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar la estructura programatica corto plazo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span></span>
                    <input type="text" name="id" hidden>
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
    modal.find('.modal-body span').text("Desea eliminar la acciona mediano plazo "+object.code+"?");
    modal.find('.modal-body input').val(object.id);
    })
    @endsection
</script>
