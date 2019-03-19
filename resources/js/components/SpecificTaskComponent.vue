<template>
    <div >
		<div class="modal fade" id="SpecificTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id='formSpecificTask' method="post" :action="url" @submit.prevent="validateBeforeSubmit">
                    
                    <div class="modal-content">
                        <div v-html='csrf'></div>

                        <div class="modal-header laravel-modal-bg">
                            <h5 class="modal-title" >{{title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
							<input type="text" name="programming_id" v-model="programming.id" hidden>
							<legend>Tarea {{task.code}}</legend>
							<div class="row">
								<div class="form-group col-md-9">
									<label>Mes </label>
									<input type="text" class="form-control" v-model="programming.name" disabled>
								</div>
								<div class="form-group col-md-3">
									<label>Meta </label>
									<input type="text" class="form-control" v-model="programming.meta" disabled>
								</div>
							</div>
							<legend>Tarea Especifica</legend>
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
		props:['url','csrf','task','programming'],
        data:()=>({
			form:{},
			title:'',
        }),
        mounted() {
			console.log('Componente SpecificTasks XD')
			console.log(this.task);

			$('#SpecificTaskModal').on('show.bs.modal',(event)=> {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var specific_task = button.data('json') // Extract info from data-* attributes
				this.title ='Nueva Tarea Especifica ';
				if(specific_task)
				{
					this.title='Editar '+specific_task.code;
				}
				console.log(specific_task);
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			
			})
		},
		methods:{
			validateBeforeSubmit() {
				this.$validator.validateAll().then((result) => {
					if (result) {
					let form = document.getElementById("formSpecificTask");
					
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