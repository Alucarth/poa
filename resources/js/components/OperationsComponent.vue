<template>
    <div >
		<div class="modal fade" id="OperationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id='formOperation' method="post" :action="url" @submit.prevent="validateBeforeSubmit">

                    <div class="modal-content">
                        <div v-html='csrf'></div>
						<input type="text" name="id" :value="form.id" v-if="form.id" hidden>
                        <div class="modal-header laravel-modal-bg">
                            <h5 class="modal-title" >{{title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
							<input type="text" name="action_short_term_id" v-model="action_short_term.id" hidden>
							<legend>Accion a Corto Plazo</legend>
							<div class="row">
								<div class="form-group col-md-9">
									<label>Descripcion </label>
									<input type="text" class="form-control" v-model="action_short_term.description" disabled>
								</div>
								<div class="form-group col-md-3">
									<label>Meta </label>
									<input type="text" class="form-control" v-model="action_short_term.meta" disabled>
								</div>
							</div>
							<legend>Operacion</legend>
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="description">Descripcion</label>
                                    <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                </div>
								<div class="form-group col-md-3">
                                    <label for="meta">Meta</label>
                                    <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                </div>
								<div class="form-group col-md-4">
                                    <label for="weighing">Ponderacion</label>
                                    <input type="text" id="weighing" name="weighing" v-model="form.weighing" class="form-control" placeholder="Ponderacion" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("weighing") }}</div>
                                </div>
                            </div>

							<legend>Estructura Programatica</legend>
							<div class="row">
								<!-- <div class="form-group col-md-3">
									<label for="code">Codigo</label>
									<v-select label="code" :options="operations" id="code" name="code" v-model="form.code"  placeholder="code" v-validate="'required'"></v-select>
									<div class="invalid-feedback">{{ errors.first("code") }}</div>
								</div> -->
								<div class="form-group  col-md-4">
									<label for="programmatic_operation">Codigo</label>
									<multiselect
										v-model="form.programmatic_operation"
										:options="operations"
										id="programmatic_operation"
										placeholder="Seleccionar Codigo"
										select-label="Seleccionar"
										deselect-label="Remover"
										selected-label="Seleccionado"
										label="code"
										track-by="code" >

									</multiselect>
									<div class="invalid-feedback">{{ errors.first("code") }}</div>
								</div>
								<div class="form-group col-md-8 " v-if="form.programmatic_operation" >
									<label for="">Descripcion</label>
									<input type="text" class="form-control" v-model="form.programmatic_operation.description" disabled >
									<input type="text" class="form-control" name='programmatic_operation_id' v-model="form.programmatic_operation.id" hidden>
								</div>
							</div>
							<!-- <div class="row" v-if="parseInt(form.meta)>0">
								<div class="alert alert-warning col-md-12" role="alert" v-show="subTotalIndicadores==parseFloat(form.meta)?false:true">
									<span v-if="subTotalIndicadores < parseFloat(form.meta)" >
										Falta <strong> {{parseFloat(form.meta)-subTotalIndicadores}}</strong> para llegar a la <strong> Meta : {{form.meta}}</strong>
									</span>
									<span v-else>
										Se sobrepaso <strong>{{subTotalIndicadores-parseFloat(form.meta)}}</strong> de la <strong> Meta : {{form.meta}}</strong>
									</span>
								</div>
							</div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
		props:['url','csrf','ast','operations'],
        data:()=>({
			form:{},
			title:'',
			action_short_term:{},
        }),
        mounted() {
			console.log('Componente Operations XD')
			this.action_short_term = JSON.parse(this.ast);
			console.log(this.operations);

			$('#OperationModal').on('show.bs.modal',(event)=> {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var operation = button.data('json') // Extract info from data-* attributes
				this.title ='Nueva Operacion ';
				if(operation)
				{
					this.title='Editar '+operation.code;
					this.form = operation;
				}else
				{
					this.form={};
				}
				console.log(operation);
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

			})
		},
		methods:{
			validateBeforeSubmit() {
				this.$validator.validateAll().then((result) => {
					if (result) {
					let form = document.getElementById("formOperation");

						form.submit();
						return;
					}
					toastr.error('Debe completar la informacion correctamente')
				});
        	},

		},
		computed:{

		}
    }
</script>
