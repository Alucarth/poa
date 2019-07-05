<template>
    <div >
		<div class="modal fade" id="ProgramaticModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<input type="text" v-if="form.id" name="programmatic_structure_id" v-model="form.id" hidden>
                            <input type="text" name="programatic_operations" :value="JSON.stringify(form.programatic_operations)">
							<legend>Estructura Programatica</legend>
							<div class="row">
                                <div class="form-group col-md-3">
                                    <label for="code">Codigo</label>
                                    <input type="text" id="code" name="code" v-model="form.code" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("code") }}</div>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="description">Descripcion</label>
                                    <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                </div>
							</div>
                            <button @click="addItem()" class="btn btn-primary" type="button"> Adicionar Operacion</button>
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">da</th>
                                        <th scope="col">ue</th>
                                        <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in this.form.programatic_operations" :key="index">
                                            <th scope="row">
                                               <input type="text" class="form-control" v-model="item.code">
                                            </th>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.description">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.da">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.ue">
                                            </td>
                                            <td>
                                                <i class="material-icons text-danger" @click="removeItem(item)">delete</i>
                                            </td>

                                        </tr>

                                    </tbody>
                                    </table>
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
    export default {
		props:['url','csrf'],
        data:()=>({
			form:{},
			title:'',
        }),
        mounted() {
			console.log('Componente Programatic Structure ')


			$('#ProgramaticModal').on('show.bs.modal',(event)=> {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var programatic_structure = button.data('json') // Extract info from data-* attributes
                console.log(programatic_structure);
            this.title ='Nueva Operacion ';
				if(programatic_structure)
				{
					this.title='Editar '+programatic_structure.code;

                    axios.get(`programatic_structure/${programatic_structure.id}`).then(response=>{
                            this.form = response.data;
                            console.log(this.form);
                            // console.log(this.form);
                            // this.meta_temp = response.data.operation.meta;
                            // this.ponderacion_temp = response.data.operation.weighing;
                    });

					// this.form = operation;
				}else
				{
					this.form={};

				}

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
            addItem()
            {
                let item = {
                    code: 0,
                    created_at: null,
                    da: 0,
                    description: '',
                    id: 0,
                    programmatic_structure_id: this.form.id,
                    ue: 0,
                    updated_at: null
                }
                this.form.programatic_operations.push(item);
            },
            removeItem(item){
                    const index = this.form.programatic_operations.indexOf(item)
                    this.form.programatic_operations.splice(index, 1)
            },


		},
		computed:{
            // getMeta(){
            //     return parseFloat(this.total_meta)+ parseFloat(this.meta_temp);
            // },
            // getPonderacion(){
            //     return parseFloat(this.total_ponderacion)+ parseFloat(this.ponderacion_temp);
            // }
		}
    }
</script>
