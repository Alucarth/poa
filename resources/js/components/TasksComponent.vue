<template>

		<div class="modal fade" id="TaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
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
                                    {{form.its_contribution}}

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
                                            <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta"  v-validate="'required|decimal:2|max_value:'+getMeta" />
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
                                                    Meta: {{ formatMoney(getMeta) }}
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

                            <div class="row" v-if="getTotalMeta>0">
                                <div :class="getTotalMeta> (form.meta || 0) ?'alert alert-danger col-md-12':'alert alert-primary col-md-12'" role="alert">
                                    Meta Tarea Especifica: <strong>{{ formatMoney(form.meta) }}</strong> y
                                    Sumatoria de las Metas: <strong>{{ formatMoney(getTotalMeta) }}</strong>
                                </div>
                            </div>
							<legend>Programacion</legend>
							<input type="text" name="programacion" :value="JSON.stringify(getMonths)" class="form-control" hidden>
							<div class="row">
								<div class="col-md-3"  v-for="(item,index) in getMonths" :key="index">
									<div class="small-box bg-primary" >
										<div class="inner" @click="item.edit=!item.edit">
                                        <div class="row">
                                            <h5>{{item.name}}
                                                    <v-chip
                                                    class="ma-2"
                                                    color="bg-success"
                                                    text-color="white"
                                                    small
                                                    v-if="form.its_contribution"
                                                    >
                                                    <v-avatar left>
                                                        <v-icon>fa-flag</v-icon>
                                                    </v-avatar>
                                                    {{item.meta_item}}
                                                    </v-chip>
                                            </h5>
                                        </div>

										<span> Meta: {{item.meta}}</span>
										</div>

										<a href="#" class="small-box-footer" @click="item.edit=!item.edit" >
											Adicionar Detalle
										<i :class="item.edit==true?'fa fa-arrow-circle-up':'fa fa-arrow-circle-down'"></i>
										</a>
										<transition  name="fade">
											<input v-if="item.edit && form.its_contribution" v-model="item.meta" v-on:keyup.enter="item.edit=false" :id='index' :name="index" v-validate="'decimal:2|max_value:'+item.meta_item" class="form-control" >
											<input v-if="item.edit && !form.its_contribution" v-model="item.meta" v-on:keyup.enter="item.edit=false" :id='index' :name="index" v-validate="'decimal:2'" class="form-control" >
										</transition>
									</div>
								</div>
							</div>

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
			form:{programmings:[]},
			title:'',
			operation:{},
			months:[],
            programming:[],
            meta_temp:0,
            ponderacion_temp:0,
            total_meta:0,
            total_ponderacion:0,
            programmings:[],
            programmation_months:[]
        }),
        mounted() {

			console.log(this.meses);
			// this.meses.forEach(month => {
			// 	month.edit =false;
			// 	month.meta ='';
			// });
			console.log('Componente Tasks v2 XD')
            // this.operation = JSON.parse(this.optask);
			this.operation = this.optask;
            // this.operation.operation_programmings.forEach(item => {
            //     let programming = {id:item.pivot.id,name:item.name ,meta: }
            // });

            // note this operation has a list of task programmations for populate boxes(task_programmings);
            console.log(this.operation);

			// this.months = this.meses;//asignacion de este siempre tiene que ser declarado en el data por la reactividad XD
			// console.log(this.gestion

			$('#TaskModal').on('show.bs.modal',(event)=> {
				let button = $(event.relatedTarget) // Button that triggered the modal
				let object = button.data('json') // task object
				let programmings = button.data('programmings');
                this.title ='Nueva Tarea ';
                // console.log(object);

                axios.get(`check_meta_task/${this.operation.id}`)
                        .then((response)=>{
                        console.log("check_meta_task");
                        console.log(response.data);
                        this.total_meta=response.data.meta;
                        this.total_ponderacion=response.data.ponderacion;
                        // this.months= [];
                        //cargando metas actualizadas
                        this.operation.operation_programmings.forEach(item => {
                            let month = _.find( response.data.task_programmings, (o) => { return o.month_id ==item.pivot.month_id });
                            if(month){
                                item.pivot.meta = month.meta;
                            }
                        });


                        // response.data.task_programmings.forEach((item) => {
                        //     let month = {id:item.month.id,operation_programming_id:item.id, name: item.month.name,meta_programming:item.meta,edit:true,meta:""};
                        //     this.months.push(month);
                        // });


                        if(object)
                        {
                            this.title='Editar Tarea '+object.code;
                            axios.get(`tasks/${object.id}`).then(response=>{
                                    this.form = response.data.task;
                                    // console.log(programmings);
                                    // console.log("imprimiendo la tarea");
                                    // console.log( response.data);
                                    // this.meta_temp = parseFloat(this.form.meta || 0);
                                    // this.ponderacion_temp = parseFloat(this.form.weighing || 0);

                                    // this.months.forEach((month) => {
                                    //     // console.log(tarea);
                                    //     let month_id=month.id;
                                    //     let mes_tarea = this.form.programmings.find((mes)=>{return mes.id == month_id });
                                    //     // console.log(mes_tarea)
                                    //     if(mes_tarea){
                                    //         month.meta =mes_tarea.pivot.meta;
                                    //     }else{
                                    //         month.meta='';
                                    //     }
                                    // });
                            });
                            // this.form.description = object.description;
                            // this.form.meta = object.meta;
                            // this.form.id = object.id;
                        }else{
                            // this.months=this.meses
                            this.form = {programmings:[]};
                            this.meta_temp = 0;
                            this.ponderacion_temp = 0;
                            this.months.forEach((month) => {
                                    month.meta='';
                            });
                        }
                });
                // console.log(object);


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
				this.getMonths.forEach(element => {
					sum+= parseFloat(element.meta|| 0);
				});
				return sum;
            },
            formatMoney(number)
            {
                return numeral(number).format('0,0.00');
            }


		},
		computed:{
            getMonths()
            {
                this.programmation_months=[];
                if(this.operation)
                {

                    if(this.form.its_contribution)
                    {
                        //populate data with task_programmations
                        console.log('operation',this.operation);
                        this.operation.operation_programmings.forEach(item => {
                            //add meta from task programming meta
                            if(item.pivot.meta >0) // success if meta distinc of 0
                            {
                                let meta ='';

                                let month = {id: item.id, name: item.name, edit:true, meta_item: item.pivot.meta, operation_programming_id:item.pivot.id, meta:meta};
                                this.programmation_months.push(month);
                            }
                        });
                    }else{
                        this.meses.forEach(item => {
                            let month = {id: item.id, name: item.name, edit:true, meta:''};
                            this.programmation_months.push(month);
                        });
                    }

                    // populate data
                    if (this.form.id)
                    {
                        this.programmation_months.forEach(item => {
                            let programming =_.find(this.form.programmings, (o) => { return o.month_id ==item.id });
                            if(programming)
                            {
                                item.meta= programming.meta;
                                item.meta_item += parseFloat(item.meta);
                            }
                        });
                    }

                }
                return this.programmation_months;
            },
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
                return  parseFloat(this.total_meta)+ parseFloat(this.meta_temp);
            },
            getPonderacion(){
                return parseFloat(this.total_ponderacion)+ parseFloat(this.ponderacion_temp);
            },
            getTotalMeta(){
                let meta =0;
                this.programmation_months.forEach(item => {
                    meta += parseFloat(item.meta || 0)
                });
                // console.log(meta);
                return meta;
            }

        },
        components: {
            Switches
        },
    }
</script>
