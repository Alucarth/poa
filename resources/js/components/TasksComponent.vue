<template>
    <div >
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
							<input type="text" name="operation_id" v-model="operation.id" hidden>
							<legend>Operacion</legend>
							<div class="row">
								
								<div class="form-group col-md-9">
									<label>Descripcion </label>
									<input type="text" class="form-control" v-model="operation.description" disabled>
								</div>
								<div class="form-group col-md-3">
									<label>Meta </label>
									<input type="text" class="form-control" v-model="operation.meta" disabled>
								</div>
							</div>
							<legend>Tarea</legend>
                            <div class="row">
								<input type="text" name="task_id" v-model="form.id" hidden>
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
							<legend>Programacion</legend>
							<input type="text" name="programacion" :value="JSON.stringify(getPrograming)" class="form-control" hidden>
							<div class="row">
								<div class="col-md-3"  v-for="(item,index) in months" :key="index">
									<div :class="item.meta.length>0?'small-box bg-primary':'small-box bg-success'" >
										<div class="inner">
										<h4>{{item.name}}<sup style="font-size: 15px"></sup></h4>

										<span>{{item.meta}}</span>
										</div>
						
										<a href="#" class="small-box-footer" @click="item.edit=!item.edit" >
											Adicionar Detalle
										<i :class="item.edit==true?'fa fa-arrow-circle-up':'fa fa-arrow-circle-down'"></i>
										</a>
										<transition  name="fade">
											<input v-if="item.edit" v-model="item.meta" v-on:keyup.enter="item.edit=false" type="number" step="any" class="form-control" >
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

    </div>
</template>

<script>
    export default {
		props:['url','csrf','optask','meses'],
        data:()=>({
			form:{},
			title:'',
			operation:{},
			months:[],
			programming:[],
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
			
			console.log(this.optask);
			this.months = this.meses;//asignacion de este siempre tiene que ser declarado en el data por la reactividad XD
			// console.log(this.gestion

			$('#TaskModal').on('show.bs.modal',(event)=> {
				let button = $(event.relatedTarget) // Button that triggered the modal
				let object = button.data('json') // Extract info from data-* attributes
				let programmings = button.data('programmings');
				this.title ='Nueva Tarea ';
				if(object)
				{
					this.title='Editar Tarea '+object.code;
					this.form.description = object.description;
					this.form.meta = object.meta;
					this.form.id = object.id;
					console.log(programmings);
					this.months.forEach((month) => {
						// console.log(tarea);
						let month_id=month.id;
						let mes_tarea = programmings.find((mes)=>{return mes.id == month_id });
						console.log(mes_tarea)
						if(mes_tarea){
							month.meta =mes_tarea.pivot.meta;
						}else{
							month.meta='';
						}
					});
				}else{
					this.months=this.meses
					this.form.description = '';
					this.form.meta = '';
					this.form.id = '';
					this.months.forEach((month) => {
							month.meta='';
					});
				}
				console.log(object);
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
			}
		}
    }
</script>