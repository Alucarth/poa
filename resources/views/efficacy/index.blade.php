@extends('layouts.adminlte')
@section('title')
    {{$title??'Inicio'}}
@endsection
@section('breadcrums')
    {{ Breadcrumbs::render('programacion_medio_plazo') }}
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
                                <th>Cod.</th>
                                <th>Denomicion</th>
                                <th>Resultado</th>
                                <th>Alcance</th>
                                <th>Ejectuado</th>
                                <th>Eficacia (%)</th>
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
                                <td>{{$item->ejecutado }}</td>
                                <td>{{$item->eficacia }}</td>
                                <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-object="{{$item}}" data-target="#efficacyModal" > <i class="fa fa-calculator"></i> </button>
                                
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

        <div class="modal fade" id="efficacyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Calculo de Eficacia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {!! Form::open(['action' => 'EfficacyController@store']) !!}
                    <div class="modal-body">
                       
                            <div class="row">
                                <input type="text" name='mpm_id' class="form-control" id='amp_id' hidden>
                                <div class="form-group  col-md-3">
                                    {!! Form::label('codigo', 'Codigo')!!}
                                    {!! Form::text('codigo','',['class'=>'form-control','id'=>'codigo','readonly'])!!}
                                </div>
                                <div class="form-group  col-md-9">
                                    {!! Form::label('meta', 'Accion MP')!!}
                                    {!! Form::text('meta','',['class'=>'form-control','id'=>'accion','readonly'])!!}
                                </div>
                            </div> 
                            <div class="row">
                                <div class="form-group  col-md-4">
                                    {!! Form::label('alcance_meta', 'Alcance de Meta')!!}
                                    {!! Form::number('alcance_meta','',['class'=>'form-control','placeholder'=>'Alcance de Meta','step'=>'any','id'=>'meta','readonly'])!!}
                                </div>
                                <div class="form-group  col-md-4">
                                    {!! Form::label('ejectuado', 'Ejectuado')!!}
                                    {!! Form::number('ejectuado','',['class'=>'form-control','placeholder'=>'Ejecutado','step'=>'any','id'=>'ejecutado'])!!}
                                </div>
                                <div class="form-group  col-md-4">
                                    {!! Form::label('eficacia', 'Eficacia (%)')!!}
                                    {!! Form::number('eficacia','',['class'=>'form-control','placeholder'=>'Eficacia','step'=>'any','id'=>'eficacia','readonly'])!!}
                                </div>
                            </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    {!! Form::close() !!}
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
         
            $('#efficacyModal').on('show.bs.modal', function (event) {
                // console.log('evento hdp ');
                var button = $(event.relatedTarget) // Button that triggered the modal
                var item = button.data('object') // Extract info from data-* attributes
                console.log(item);
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body #amp_id').val(item.id);
                modal.find('.modal-body #codigo').val(item.codigo);
                modal.find('.modal-body #accion').val(item.descripcion);
                modal.find('.modal-body #meta').val(item.alcance_meta);
                modal.find('.modal-body #ejecutado').val(item.ejecutado);
                // modal.find('.modal-body #ejecutado').attr('max',item.ejecutado);
                modal.find('.modal-body #eficacia').val(item.eficacia);

                $('.modal-body #ejecutado').on('input', function()  {
                    // Check input( $( this ).val() ) for validity here
                    let value = $(this).val();
                    if(!isNaN(value))
                    {                     
                       let porcentaje = numeral((100*value)/item.alcance_meta).format('0,00');
                        console.log(porcentaje);
                        modal.find('.modal-body #eficacia').val(porcentaje);
                    }
                    // console.log($(this).val())
                });
                
            })
        };
    </script>    
@endsection