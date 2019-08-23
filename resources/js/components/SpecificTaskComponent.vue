<template>
    <div >
		<div class="modal fade" id="SpecificTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id='formSpecificTask' method="post" :action="url" @submit.prevent="validateBeforeSubmit">

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
							<input type="text" name="programming_id" v-model="programming.id" hidden>
							<legend>Tarea {{task.code}}</legend>
							<div class="row">
								<v-chip color="bg-success" text-color="white">
                                    <v-avatar class="green darken-3">
                                        <v-icon >fa-flag</v-icon>
                                    </v-avatar>
                                        Meta: {{getMeta}}
                                </v-chip>
                                <v-chip color="bg-info" text-color="white">
                                    <v-avatar class="cyan darken-3">
                                        <v-icon >fa-percentage</v-icon>
                                    </v-avatar>
                                        Ponderacion Disponible: {{getPonderacion}}
                                </v-chip>
							</div>
                            <div class="form-group col-md-3">
                                <label for="description">Contribuye a la Meta :   {{form.its_contribution?'Si':'No'}}</label>
                                <switches v-model="form.its_contribution"  theme="bootstrap" color="primary"></switches>
                                <input type="text" name="its_contribution" :value="form.its_contribution" hidden>
                            </div>
							<legend>Tarea Especifica</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="code">Numeración</label>
                                    <input type="text" id="code" name="code" v-model="form.code" class="form-control" placeholder="Codigo" v-validate="'required|decimal'" />
                                    <div class="invalid-feedback">{{ errors.first("code") }}</div>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="description">Descripcion</label>
                                    <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                </div>
								<div class="form-group col-md-3">
                                    <label for="meta">Meta</label>
                                    <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2|max_value:'+getMeta" />
                                    <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                </div>
								<div class="form-group col-md-3">
                                    <label for="weighing">Ponderacion (%)</label>
                                    <input type="text" id="weighing" name="weighing" v-model="form.weighing" class="form-control" placeholder="ponderacion" v-validate="'required|decimal:2|max_value:'+getPonderacion" />
                                    <div class="invalid-feedback">{{ errors.first("weighing") }}</div>
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
    import Switches from 'vue-switches';
    export default {
		props:['url','csrf','task','programming'],
        data:()=>({
			form:{},
            title:'',
            meta_temp:0,
            ponderacion_temp:0,
            total_meta:0,
            total_ponderacion:0,
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
                     axios.get(`specific_tasks/${specific_task.id}`).then(response=>{
                         this.form = response.data.specific_task;
                         this.meta_temp = parseFloat(response.data.specific_task.meta || 0);
                         this.ponderacion_temp = parseFloat(response.data.specific_task.weighing || 0);
                     });

				}else{
                    this.form ={};
                    this.meta_temp = 0;
                    this.ponderacion_temp = 0;
				}
                console.log(specific_task);

                 axios.get(`check_meta_specific_task/${this.programming.id}`)
                      .then(response=>{
                        console.log(response.data);
                        this.total_meta=response.data.meta;
                        this.total_ponderacion=response.data.ponderacion;
                        //console.log(this.total_meta);

                    });
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

            getMeta(){
                return parseFloat(this.total_meta)+ parseFloat(this.meta_temp);
            },
            getPonderacion(){
                return parseFloat(this.total_ponderacion)+ parseFloat(this.ponderacion_temp);
            }
        },
        components: {
            Switches
        },
    }
</script>
