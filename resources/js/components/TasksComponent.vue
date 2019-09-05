<template>

		<div class="modal fade" id="TaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id='formTask' method="post" :action="url" @submit.prevent="validateBeforeSubmit">

                    <div class="modal-content">
                        <div v-html='csrf'></div>

                        <div class="modal-header laravel-modal-bg">
                            <h5 class="modal-title" >{{title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <legend>Tarea</legend>
                                    <div class="row">
                                        <input type="text" name="task_id" v-model="form.id" hidden>
                                        <div class="col-md-4">
                                            <label for="code">Numeración</label>
                                            <input type="text" id="code" name="code" v-model="form.code" class="form-control" placeholder="Codigo" v-validate="'required|decimal'" />
                                            <div class="invalid-feedback">{{ errors.first("code") }}</div>
                                        </div>

                                        <div class="form-group col-md-4" v-if="!form.its_contribution">
                                            <label for="meta">Meta</label>
                                            <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2'" />
                                            <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                        </div>
                                        <div class="form-group col-md-4" v-else>
                                            <label for="meta">Meta</label>
                                            <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2|max_value:'+getMeta" />
                                            <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="weighing">Ponderacion (%) </label>
                                            <input type="text" id="weighing" name="weighing" v-model="form.weighing" class="form-control" placeholder="ponderacion" v-validate="'decimal:2|max_value:'+getPonderacion" />
                                            <div class="invalid-feedback">{{ errors.first("weighing") }}</div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Descripcion</label>
                                            <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                            <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">

                                    <input type="text" name="operation_id" v-model="operation.id" hidden>
                                     <div class="card" >
                                        <div class="card-body">

                                        <legend>Operacion</legend>
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
                                                    Ponderacion: {{getPonderacion}}
                                            </v-chip>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for="description">Contribuye a la Meta :   {{form.its_contribution?'Si':'No'}}</label>
                                            <switches v-model="form.its_contribution"  theme="bootstrap" color="primary"></switches>
                                            <input type="text" name="its_contribution" :value="form.its_contribution" hidden>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


							<legend>Programacion</legend>
							<input type="text" name="programacion" :value="JSON.stringify(getPrograming)" class="form-control" hidden>
							<div class="row">
								<div class="col-md-3"  v-for="(item,index) in months" :key="index">
									<div :class="item.meta.length>0?'small-box bg-primary':'small-box bg-success'" >
										<div class="inner" @click="item.edit=!item.edit">
										<h4>{{item.name}}<sup style="font-size: 15px"></sup></h4>

										<span>{{item.meta}}</span>
										</div>

										<a href="#" class="small-box-footer" @click="item.edit=!item.edit" >
											Adicionar Detalle
										<i :class="item.edit==true?'fa fa-arrow-circle-up':'fa fa-arrow-circle-down'"></i>
										</a>
										<transition  name="fade">
											<input v-if="item.edit" v-model="item.meta" v-on:keyup.enter="item.edit=false" :id='index' :name="index" v-validate="'decimal:2'" class="form-control" >
										</transition>
									</div>
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
                            <button type="button" class="btn btn-success" @click="validate()">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

</template>

<script>
    import Switches from 'vue-switches';
    export default {
		props:['url','csrf','optask','meses'],
        data:()=>({
			form:{},
			title:'',
			operation:{},
			months:[],
            programming:[],
            meta_temp:0,
            ponderacion_temp:0,
            total_meta:0,
            total_ponderacion:0,
            programmings:[],
        }),
        mounted() {

			console.log(this.meses);
			this.meses.forEach(month => {
				month.edit =false;
				month.meta ='';
			});
			console.log('Componente Tasks XD')
			// this.operation = JSON.parse(this.optask);
			this.operation = this.optask;

			console.log(this.operation);
			this.months = this.meses;//asignacion de este siempre tiene que ser declarado en el data por la reactividad XD
			// console.log(this.gestion

			$('#TaskModal').on('show.bs.modal',(event)=> {
				let button = $(event.relatedTarget) // Button that triggered the modal
				let object = button.data('json') // Extract info from data-* attributes
				let programmings = button.data('programmings');
                this.title ='Nueva Tarea ';
                // console.log(object);
				if(object)
				{
                    this.title='Editar Tarea '+object.code;
                    axios.get(`tasks/${object.id}`).then(response=>{
                            this.form = response.data.task;
                            // console.log(programmings);
                            console.log("imprimiendo la tarea");
                            console.log( response.data);
                            this.meta_temp = parseFloat(this.form.meta || 0);
                            this.ponderacion_temp = parseFloat(this.form.weighing || 0);
                            // console.log(this.meta_temp);
                            // console.log(this.ponderacion_temp);
                            // console.log(programmings);
                            // programmings = this.form.programmings;
                            this.months.forEach((month) => {
                                // console.log(tarea);
                                let month_id=month.id;
                                let mes_tarea = this.form.programmings.find((mes)=>{return mes.id == month_id });
                                // console.log(mes_tarea)
                                if(mes_tarea){
                                    month.meta =mes_tarea.pivot.meta;
                                }else{
                                    month.meta='';
                                }
                            });
                    });
					// this.form.description = object.description;
					// this.form.meta = object.meta;
					// this.form.id = object.id;
				}else{
					// this.months=this.meses
                    this.form = {};
                    this.meta_temp = 0;
                    this.ponderacion_temp = 0;
					this.months.forEach((month) => {
							month.meta='';
					});
				}
                // console.log(object);

                 axios.get(`check_meta_task/${this.operation.id}`)
                      .then((response)=>{
                        console.log("check_meta_task");
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

			},
			validate()
			{
				this.$validator.validateAll().then((result) => {
					if (result) {

						let form = document.getElementById("formTask");
						if( this.subTotalTask() == this.form.meta )
						{
							form.submit();
						}else{
							toastr.info('La meta del Tarea:'+this.form.meta+' debe ser igual a la Suma de las Tareas:'+this.subTotalTask()+' por mes')
						}

						 return;
					}
					toastr.error('Debe completar la informacion correctamente')
				});
			},
			subTotalTask(){
				let sum=0;
				this.getPrograming.forEach(element => {
					sum+= parseFloat(element.meta);
				});
				return sum;
			}

		},
		computed:{
			getPrograming(){
				this.programming=[];
				this.months.forEach(month => {
					if(month.meta!=''){
						this.programming.push(month);
					}
				});
				return this.programming;
            },
            getMeta(){
                return parseFloat(this.total_meta)+ parseFloat(this.meta_temp);
            },
            getPonderacion(){
                return parseFloat(this.total_ponderacion)+ parseFloat(this.ponderacion_temp);
            },

        },
        components: {
            Switches
        },
    }
</script>
