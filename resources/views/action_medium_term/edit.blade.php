
<h3 class="card-title text-right">
    <a href="{{url('amp_report_excel')}}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> </a> 
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ActionMediumTermModal" data-json="{}" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
</h3>
{{-- modal dialog --}}

    <div class="modal fade" id="ActionMediumTermModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {!! Form::open(['action' => 'ActionMediumTermController@store']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <legend>Estructura del POES</legend>    
                    <div class="row">
                        <div class="form-group  col-md-3">
                            {!! Form::label('pilar', 'Pilar')!!}
                            {!! Form::number('pilar','',['class'=>'form-control','placeholder'=>'Pilar'])!!}
                        </div>
                        <div class="form-group  col-md-3">
                            {!! Form::label('meta', 'Meta')!!}
                            {!! Form::number('meta','',['class'=>'form-control','placeholder'=>'Meta'])!!}
                        </div>
                        <div class="form-group  col-md-3">
                            {!! Form::label('resultado', 'Resultado')!!}
                            {!! Form::number('resultado','',['class'=>'form-control','placeholder'=>'Resultado'])!!}
                        </div>
                        <div class="form-group  col-md-3">
                            {!! Form::label('accion', 'Accion')!!}
                            {!! Form::number('accion','',['class'=>'form-control','placeholder'=>'Accion'])!!}
                        </div>
                    </div>    
                    <legend>Accion de Mediano Plazo del PEE</legend>
                    <div class="row">
                        <div class="form-group  col-md-10">
                            {!! Form::label('descripcion', 'Descripcion')!!}
                            {!! Form::text('descripcion','',['class'=>'form-control','placeholder'=>'Descripcion'])!!}
                        </div>
                        <div class="form-group  col-md-4">
                            {!! Form::label('tipo', 'Tipo')!!}
                            {!! Form::select('tipo', ['Proceso' => 'Proceso', 'Apoyo' => 'Apoyo'],null,['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('resultado_intermedio', 'Resultado Intermedio')!!}
                            {!! Form::text('resultado_intermedio','',['class'=>'form-control','placeholder'=>'Resultado Intermedio'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('linea_base', 'Linea Base')!!}
                            {!! Form::text('linea_base','',['class'=>'form-control','placeholder'=>'Linea Base'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('indicador_resultado', 'Indicador de Resultado')!!}
                            {!! Form::text('indicador_resultado','',['class'=>'form-control','placeholder'=>' Indicador de Resultado'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('alcance_meta', 'Alcance de Meta')!!}
                            {!! Form::number('alcance_meta','',['class'=>'form-control','placeholder'=>'Alcance de Meta','step'=>'any'])!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


<script>
        window.onload = function () {
            // $('#ActionMediumTermModal').on('show.bs.modal', function (event) {
            // var button = $(event.relatedTarget) // Button that triggered the modal
            // var recipient = button.data('json') // Extract info from data-* attributes
            // console.log(recipient);
            // // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            // var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            // modal.find('.modal-body input').val(recipient)
            // })
        };
</script>    
