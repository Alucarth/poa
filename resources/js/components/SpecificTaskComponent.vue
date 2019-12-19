<template>
    <div >
		<div class="modal fade" id="SpecificTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
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
							<input type="text" name="task_id" v-model="task.id" hidden>
                            <div class="row">
                                <div class="col-md-6">

                                    <legend>Tarea Especifica</legend>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="code">Numeración</label>
                                            <input type="text" id="code" name="code" v-model="form.code" class="form-control" placeholder="Codigo" v-validate="'required|decimal'" />
                                            <div class="invalid-feedback">{{ errors.first("code") }}</div>
                                        </div>

                                        <div class="form-group col-md-4" v-if="form.its_contribution">
                                            <label for="meta">Meta</label>
                                            <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2|max_value:'+getMeta" />
                                            <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                        </div>
                                        <div class="form-group col-md-4" v-else>
                                            <label for="meta">Meta</label>
                                            <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2'" />
                                            <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="weighing">Ponderacion (%)</label>
                                            <input type="text" id="weighing" name="weighing" v-model="form.weighing" class="form-control" placeholder="ponderacion" v-validate="'required|decimal:2|max_value:'+getPonderacion" />
                                            <div class="invalid-feedback">{{ errors.first("weighing") }}</div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Descripcion</label>
                                            <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                            <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card" >
                                        <div class="card-body">
                                        <legend>Tarea {{task.code}}</legend>
                                        <div class="row">
                                            <v-chip color="bg-success" text-color="white">
                                                <v-avatar class="green darken-3">
                                                    <v-icon >fa-flag</v-icon>
                                                </v-avatar>
                                                    Meta: {{formatMoney(getMeta)}}
                                            </v-chip>
                                            <v-chip color="bg-info" text-color="white">
                                                <v-avatar class="cyan darken-3">
                                                    <v-icon >fa-percentage</v-icon>
                                                </v-avatar>
                                                    Ponderacion Disponible: {{getPonderacion}}
                                            </v-chip>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="description">Contribuye a la Meta :   {{form.its_contribution?'Si':'No'}}</label>
                                            <switches v-model="form.its_contribution"  theme="bootstrap" color="primary"></switches>
                                            <input type="text" name="its_contribution" :value="form.its_contribution" hidden>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row" v-if="!form.its_contribution">
                                <div :class="getTotalAllMeta <= form.meta?'alert alert-primary col-md-12':'alert alert-danger col-md-12'"  role="alert">
                                    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-trash-restore-alt" @click="clearProgrammations()"></i> </button>  Meta: {{form.meta}} y  la sumatoria de las metas es: {{getTotalAllMeta}}
                                </div>
                            </div>
                            <!-- <input type="text" name="specific_programmings" :value="JSON.stringify(this.programmings)" hidden> -->
                            <div class="row" v-else>
                                <div :class="getTotalMeta > (form.meta || 0) ?'alert alert-danger col-md-12':'alert alert-primary col-md-12'" role="alert">
                                    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-trash-restore-alt" @click="clearProgrammations()"></i> </button>
                                    Meta Tarea Especifica: <strong>{{ formatMoney(form.meta) }}</strong> y
                                    Sumatoria de las Metas: <strong>{{ formatMoney(getTotalMeta)  }}</strong>
                                </div>
                            </div>
                            <div class="row" v-if="form.its_contribution" >
                                <input type="text" name="specific_programmings" :value="JSON.stringify(this.programmings)" hidden>
								<div class="col-md-3"  v-for="(item,index) in programmings" :key="index">
									<div class="small-box bg-primary" >
										<div class="inner" @click="item.edit=!item.edit">
                                        <div class="row">
                                            <h5>{{item.name}}
                                                    <v-chip
                                                    class="ma-2"
                                                    color="bg-success"
                                                    text-color="white"
                                                    small
                                                    >
                                                    <v-avatar left>
                                                        <v-icon>fa-flag</v-icon>
                                                    </v-avatar>
                                                    {{item.meta_programming}}
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
											<input v-if="item.edit" v-model="item.meta" v-on:keyup.enter="item.edit=false" :id='index' :name="index" v-validate="'decimal:2|max_value:'+item.meta_programming" class="form-control" >
										</transition>
									</div>
								</div>
							</div>
                            <div class="row" v-else>
                                <input type="text" name="specific_programmings" :value="JSON.stringify(all_programmings)" hidden>
                                <div class="col-md-3"  v-for="(item,index) in all_programmings" :key="index">
									<div class="small-box bg-primary" >
										<div class="inner" @click="item.edit=!item.edit">
                                        <div class="row">
                                            <h5>{{item.name}}
                                            </h5>
                                        </div>

										<span> Meta: {{item.meta}}</span>
										</div>

										<a href="#" class="small-box-footer" @click="item.edit=!item.edit" >
											Adicionar Detalle
										<i :class="item.edit==true?'fa fa-arrow-circle-up':'fa fa-arrow-circle-down'"></i>
										</a>
										<transition  name="fade">
											<input v-if="item.edit" v-model="item.meta" v-on:keyup.enter="item.edit=false" :id='index' :name="index"  class="form-control" >
										</transition>
									</div>
								</div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <!-- {{getTotalMeta}} -->
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
		props:['url','csrf','task','months'],
        data:()=>({
			form:{},
            title:'',
            meta_temp:0,
            ponderacion_temp:0,
            total_meta:0,
            total_ponderacion:0,
            programmings:[],
            specific_task_programmings:[],
            meses:[],
            all_programmings:[]

        }),
        mounted() {
			console.log('Componente SpecificTasks XD')
            console.log(this.task);
            console.log(this.months);

            this.months.forEach(month => {
                let item = {};
                // item.programming_id = programming.pivot.id
                item.month_id = month.id;
                item.name = month.name
                // item.meta_programming = programming.pivot.meta
                item.meta = ""
                item.edit = true;
                this.all_programmings.push(item);
            });
            console.log(this.all_programmings);
            // this.task.programmings.forEach(programming => {
            //     let item={};
            //     item.programming_id = programming.pivot.id
            //     item.name = programming.name
            //     item.meta_programming = programming.pivot.meta
            //     item.meta = ""
            //     item.edit = true;
            //     this.programmings.push(item);
            // });
            // console.log(this.programmings);
			$('#SpecificTaskModal').on('show.bs.modal',(event)=> {

                var button = $(event.relatedTarget) // Button that triggered the modal
				var specific_task = button.data('json') // Extract info from data-* attributes
                this.title ='Nueva Tarea Especifica ';
                this.specific_task_programmings =[];
				if(specific_task)
				{
                    this.title='Editar '+specific_task.code;
                    axios.get(`specific_tasks/${specific_task.id}`).then(response=>{
                    //  console.log(response.data);
                        this.form = response.data.specific_task;
                        this.meta_temp = parseFloat(response.data.specific_task.meta || 0);
                        this.ponderacion_temp = parseFloat(response.data.specific_task.weighing || 0);
                        this.specific_task_programmings = response.data.specific_task_programmation;
                        console.log(this.specific_task_programmings);
                        if(this.form.its_contribution)
                        {
                        this.MetaCheck()
                        }else{
                            this.MetaCheck()
                        this.loadMonths()
                        }
                    });

				}else{
                    this.form ={};
                    this.meta_temp = 0;
                    this.ponderacion_temp = 0;
                    this.MetaCheck()
				}
                // console.log(specific_task);

				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

			})
		},
		methods:{
			validateBeforeSubmit() {
				this.$validator.validateAll().then((result) => {
                    if (result)
                    {
                        if(this.form.its_contribution)
                        {
                            if(this.getTotalMeta != this.form.meta)
                            {
                                toastr.error('La sumatoria de las metas dede ser iguala a la meta de la tarea especifica')
                            }else
                            {

                                let form = document.getElementById("formSpecificTask");

                                form.submit();
                                return;
                            }
                        }
                        else
                        {
                            if(this.getTotalAllMeta != this.form.meta)
                            {
                                toastr.error('La sumatoria de las metas dede ser iguala a la meta de la tarea especifica')
                            }else
                            {
                                let form = document.getElementById("formSpecificTask");

                                form.submit();
                                return;
                            }
                        }
                    }
                    toastr.error('Debe completar la informacion correctamente')
				});
            },
            MetaCheck(){

                axios.get(`check_meta_specific_task/${this.task.id}`)
                    .then(response=>{
                        console.log('check_meta_specific_task',response.data);
                        this.total_meta=response.data.meta;
                        this.total_ponderacion=response.data.ponderacion;

                        this.programmings = [];

                            response.data.specific_programmings.forEach(programming => {
                                let item={};
                                item.programming_id = programming.id
                                item.name = programming.month.name
                                item.month_id = programming.month_id
                                item.meta_programming = programming.meta
                                item.meta = ""
                                item.edit = true;
                                // if(this.form.its_contribution)
                                // {
                                //     console.log('iterando si contribuye');
                                //     if(this.specific_task_programmings.length > 0)
                                //     {

                                //         let item_finded = _.find(this.specific_task_programmings, (o) => { return o.programming?o.programming.month_id:0  == programming.month_id; });
                                //         console.log(item_finded)
                                //         if(item_finded)
                                //         {
                                //             item.id = item_finded.id;
                                //             item.meta_programming = parseFloat (item_finded.meta);
                                //             item.meta = parseFloat(item_finded.meta);
                                //         }
                                //     }
                                // }

                                this.programmings.push(item);
                            });
                            if(this.form.its_contribution)
                            {
                                if(this.specific_task_programmings.length > 0)
                                {
                                    console.log('poblando')
                                    this.programmings.forEach(item => {
                                        // console.log(item);
                                        let item_finded = _.find(this.specific_task_programmings, (o) =>{ return o.programming_id == item.programming_id; });
                                        if(item_finded){
                                            item.meta = parseFloat(item_finded.meta)
                                            item.id = item_finded.id;
                                            item.meta_programming += parseFloat (item.meta);
                                        }
                                        console.log(item_finded);
                                    });
                                }
                            }



                    });
            },
            loadMonths()
            {
                this.all_programmings.forEach(programming => {
                    let item_finded = _.find(this.specific_task_programmings, (o) => { return o.month_id == programming.month_id; });
                    console.log(item_finded);
                    if(item_finded)
                    {
                        programming.meta= item_finded.meta;
                    }
                    return programming;
                });
            },
            clearProgrammations()
            {
                console.log('borrando todos los items');
                if(this.form.its_contribution)
                {
                    this.programmings.forEach(item => {
                        item.meta='';
                    });
                }else{

                    this.all_programmings.forEach(item => {
                        console.log(item);
                        item.meta=''
                    });
                }

            },

            formatMoney(number)
            {
                return numeral(number).format('0,0.00');
            }

		},
		computed:{

            getMeta(){
                let meta =0;
                if(this.form.its_contribution)
                {
                    meta = parseFloat(this.total_meta)+ parseFloat(this.meta_temp);
                }else{
                    meta = parseFloat(this.total_meta);
                }
                return meta;
            },
            getPonderacion(){
                return parseFloat(this.total_ponderacion)+ parseFloat(this.ponderacion_temp);
            },
            getTotalMeta(){
                let meta =0;
                this.programmings.forEach(item => {
                    meta+= parseFloat(item.meta || 0)
                });
                // console.log(meta);
                return meta;
            },
            getTotalAllMeta()
            {
                let meta =0;
                this.all_programmings.forEach(item => {
                    meta+= parseFloat(item.meta || 0)
                });
                return meta;
            }

        },
        components: {
            Switches
        },
    }
</script>
