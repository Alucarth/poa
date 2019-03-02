<template>
    <div >
		<div class="modal fade" id="ActionShortTermModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id='formActionShortTerm' method="post" :action="url" @submit.prevent="validateBeforeSubmit">
                    
                    <div class="modal-content">
                        <div v-html='csrf'></div>
                
                        <div class="modal-header laravel-modal-bg">
                            <h5 class="modal-title" >{{title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
							<input type="text" name="year_id" v-model="gestion.id" hidden>
							<legend>Gestion {{gestion.year}}</legend>
							<div class="row">
								<div class="form-group col-md-4">
									<label for="meta">Meta</label>
									<input type="text" id="meta" name="meta" v-model="gestion.meta" class="form-control" placeholder="Meta" disabled />
								</div>
							</div>
							<legend>Acion a Corto Plazo</legend>
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="description">Descripcion</label>
                                    <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                </div>
                            </div>

                            <legend>Indicador</legend>

							<div class="row">
								<div class="form-group col-md-4">
                                    <label for="unidad_de_medida">Unidad de Medida</label>
                                    <input type="text" id="unidad_de_medida" name="unidad_de_medida" v-model="form.unidad_de_medida" class="form-control" placeholder="Unidad de Medida" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("unidad_de_medida") }}</div>
                                </div>
								<div class="form-group col-md-4">
                                    <label for="producto_esperado">Producto Esperado</label>
                                    <input type="text" id="producto_esperado" name="producto_esperado" v-model="form.producto_esperado" class="form-control" placeholder="Producto Esperado" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("producto_esperado") }}</div>
                                </div>
								<div class="form-group col-md-4">
                                    <label for="linea_base">Linea Base</label>
                                    <input type="text" id="linea_base" name="linea_base" v-model="form.linea_base" class="form-control" placeholder="Linea Base" v-validate="''" />
                                    <div class="invalid-feedback">{{ errors.first("linea_base") }}</div>
                                </div>
								<div class="form-group col-md-3">
                                    <label for="meta">Meta</label>
                                    <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("meta") }}</div> 
                                </div>
								<!-- <div class="d-flex justify-content-center">
									<div class="p-2 ">
										<button type="button" class="btn btn-primary btn-sm " @click="addItem()"> Adicionar Indicador <i class="fa fa-plus-circle"></i> </button>
									</div>
									<div class="p-2">
										<button type="button" class="btn btn-danger btn-sm " @click="addItem()"> Eliminar Todo <i class="fa fa-trash"></i> </button>
									</div>
									<input type="text" name="indicadores" :value="JSON.stringify(indicadores)" class="form-control" hidden>
								</div> -->
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
		props:['url','csrf','year'],
        data:()=>({
			indicadores:[],
			form:{},
			title:'',
			gestion:{},
        }),
        mounted() {
			console.log('Componente Indicadores XD')
			this.gestion = JSON.parse(this.year);
			console.log(this.gestion);

			this.indicadores.push({descripcion:'',unidad:'',linea_base:'',meta:0,producto_esperado:''});
			
			$('#ActionShortTermModal').on('show.bs.modal',(event)=> {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var amt = button.data('json') // Extract info from data-* attributes
				this.title ='Nueva Accion a Corto Plazo ';
				if(amt)
				{
					this.title='Editar '+amt.code;
				}
				console.log(amt);
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			
			})
		},
		methods:{
			validateBeforeSubmit() {
				this.$validator.validateAll().then((result) => {
					if (result) {

					let form = document.getElementById("formActionShortTerm");
						
						if(parseFloat(this.gestion.meta)>=parseFloat(this.form.meta)){
						form.submit();
						}else{
							toastr.info(' La Meta de la Accion a Mediano Plazo: '+this.form.meta+' no puede ser mayor la Meda de la Gestion: '+this.gestion.meta+'');
						}
						return;
					}
					toastr.error('Debe completar la informacion correctamente')
				});
        	},
			addItem(){
				this.indicadores.push({descripcion:'',unidad:'',linea_base:'',meta:0,producto_esperado:''});
			},
			removeItem(item){
				const index = this.indicadores.indexOf(item)
				this.indicadores.splice(index, 1)
			},
			removeAll(){
				this.indicadores =[];
				this.indicadores.push({descripcion:'',unidad:'',linea_base:'',meta:0,producto_esperado:''});
			}
		},
		computed:{
			subTotalIndicadores(){
				let amount=0;
				this.indicadores.forEach(element => {
					amount+=parseFloat(element.meta);   
				});
				return amount;
			},
		}
    }
</script>