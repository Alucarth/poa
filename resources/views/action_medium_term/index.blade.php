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

                    <table id="lista" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                {{-- <th>Nº</th> --}}
                                <th>Cod.</th>
                                <th>Accion Mediano Plazo</th>
                                <th>Resultado</th>
                                <th>Meta</th>
                                <th>Ponderacion</th>
                                <th>Ejecutado</th>
                                <th>Eficacia</th>
                                <th>Opciones</th>
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
                                    <a href="{{url('action_short_term_year/'.$item->years[0]->id)}}"><i class="material-icons text-warning">folder</i></a>
                                    <a href="#" data-toggle="modal" data-target="#ActionMediumTermModal" data-backdrop="static" data-keyboard="false" data-json="{{$item}}"><i class="material-icons text-primary">edit</i></a>
                                    {{-- <a href="#"> <i class="material-icons text-danger deleted" data-json='{{$item}}'>delete</i></a> --}}
                                    <a href="#" data-toggle="modal" data-target="#deleteModal" data-backdrop="static" data-keyboard="false" data-json="{{$item}}"><i class="material-icons text-danger">delete</i></a>
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


        // var classname = document.getElementsByClassName("deleted");
        // // console.log(classname);
        // function deleteItem(){

        //     var data = JSON.parse(this.getAttribute("data-json"));

        //     Swal.fire({
        //     title: 'Esta Seguro de Eliminar '+data.code+'?',
        //     text: "una vez eliminado no se podra revertir la accion!",
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Si, borrar!',
        //     cancelButtonText: 'No'
        //     }).then((result) => {
        //     if (result.value) {

        //         axios.delete(`action_medium_term/${data.id}`)
        //             .then(response=>{
        //                 console.log(response);
        //                 location.reload();
        //             })
        //             .catch(error=>{
        //                 // handle error
        //                 Swal.fire(
        //                 'Error! contactese con soporte tecnico',
        //                 ''+error,
        //                 'error'
        //                 )
        //                 // console.log(error);
        //             });


        //     }
        //     })

        // }
        // for (var i = 0; i < classname.length; i++) {
        //     classname[i].addEventListener('click', deleteItem, false);
        // }
    @endsection
</script>
