<template>
    <div >
		<div class="modal fade" id="OperationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
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
                            <div class="row">
                                <div class="col-md-4">
                                    <legend>Operacion</legend>
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
                                        <div class="form-group col-md-4" v-if="!form.its_contribution">
                                            <label for="meta">Meta</label>
                                            <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2'" />
                                            <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="weighing">Ponderacion</label>
                                            <input type="text" id="weighing" name="weighing" v-model="form.weighing" class="form-control" placeholder="Ponderacion" v-validate="'required|decimal:2|max_value:'+getPonderacion" />
                                            <div class="invalid-feedback">{{ errors.first("weighing") }}</div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Descripcion</label>
                                            <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                            <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                        </div>

                                    </div>
                                    <div class="row" v-if="getTotalMeta>0">
                                        <div :class="getTotalMeta > (form.meta || 0) ?'alert alert-danger col-md-12':'alert alert-primary col-md-12'" role="alert">
                                            Meta: <strong>{{form.meta}}</strong> y
                                            Sumatoria de Metas: <strong>{{ getTotalMeta }}</strong>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-5">
                                    <div class="card" >
                                        <div class="card-body">
                                            <input type="text" name="programmatic_operations" :value="JSON.stringify(form.programmatic_operations)" hidden>
                                            <button @click="addItem()" type="button" class="btn btn-secondary"> <i class="fa fa-plus"></i> Esctructura Programatica</button>
                                            <div class="row">

                                                <table class="table ">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Codigo</th>
                                                    <th scope="col">Descripcion</th>
                                                    <th scope="col"></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item,index) in form.programmatic_operations" :key="index">
                                                        <td>
                                                        <multiselect
                                                            v-model="form.programmatic_operations[index]"
                                                            :options="operations"
                                                            id="programmatic_operation"
                                                            placeholder="Seleccionar Codigo"
                                                            select-label="Seleccionar"
                                                            deselect-label="Remover"
                                                            selected-label="Seleccionado"
                                                            label="code"
                                                            track-by="code" >

                                                        </multiselect>
                                                        </td>
                                                        <td>
                                                            <input v-if="form.programmatic_operations[index]" type="text" class="form-control" v-model="form.programmatic_operations[index].description" disabled>
                                                        </td>
                                                        <td>
                                                            <i class="material-icons text-danger" @click="removeItem(item)">delete</i>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card" >
                                        <div class="card-body">
                                            <legend>Accion a Corto Plazo</legend>
                                            <div class="row">
                                                <div class="col-md-12">
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
                                                            Ponderacion : {{getPonderacion}}
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
                            </div>

                        <!-- renderizando los 12 meses -->
                        	<legend>Programacion</legend>
							<input type="text" name="programacion" :value="JSON.stringify(getPrograming)" class="form-control" hidden>
							<div class="row">
								<div class="col-md-2"  v-for="(item,index) in months" :key="index">
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
		props:['url','csrf','ast','operations','meses'],
        data:()=>({
			form:{},
			title:'',
			action_short_term:{},
            meta_temp:0,
            ponderacion_temp:0,
            total_meta:0,
            total_ponderacion:0,
            months:[]
        }),
        mounted() {
			console.log('Componente Operations XD')
			this.action_short_term = JSON.parse(this.ast);
            console.log(this.operations);
            console.log(this.meses);
            this.meses.forEach(month => {
				month.edit =true;
				month.meta ='';
            });
            this.months = this.meses;
            // $('#OperationModal').modal({backdrop: 'static', keyboard: false})
			$('#OperationModal').on('show.bs.modal',(event)=> {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var operation = button.data('json') // Extract info from data-* attributes
				this.title ='Nueva Operacion ';
				if(operation)
				{
					this.title='Editar '+operation.code;

                    axios.get(`operations/${operation.id}`).then(response=>{
                            this.form = response.data.operation;
                            console.log(response.data);
                            this.meta_temp = parseFloat(response.data.operation.meta || 0);
                            this.ponderacion_temp = parseFloat(response.data.operation.weighing || 0);

                            this.months.forEach((month) => {
                                // console.log(tarea);
                                let month_id=month.id;
                                let mes_tarea = this.form.operation_programmings.find((mes)=>{return mes.id == month_id });
                                // console.log(mes_tarea)
                                if(mes_tarea){
                                    month.meta =mes_tarea.pivot.meta;
                                }else{
                                    month.meta='';
                                }
                            });
                    });

					// this.form = operation;
				}else
				{
					this.form={programmatic_operations:[]};
                    this.meta_temp = 0;
                    this.ponderacion_temp = 0;
				}
				console.log(operation);

                axios.get(`check_meta_operation/${this.action_short_term.id}`)
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
                    if(this.getTotalMeta != this.form.meta)
                    {
                        toastr.error('La sumatoria de las metas dede ser iguala a la meta de la operacion')
                    }else{

                        let form = document.getElementById("formOperation");

                            form.submit();
                            return;
                        }
                    }
					toastr.error('Debe completar la informacion correctamente')
				});
            },
            addItem (){
                this.form.programmatic_operations.push({});
            },
            removeItem(item){
                const index = this.form.programmatic_operations.indexOf(item)
                this.form.programmatic_operations.splice(index, 1)
            },

		},
		computed:{
            getMeta(){
                let value = parseFloat(this.total_meta)+ parseFloat(this.meta_temp)

                return value;
            },
            getPonderacion(){
                return parseFloat(this.total_ponderacion)+ parseFloat(this.ponderacion_temp);
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
            getTotalMeta(){
                let meta =0;
                this.months.forEach(item => {
                    meta+= parseFloat(item.meta || 0)
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
