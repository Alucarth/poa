
<template>
<div>
        <div class="modal fade" id="ActionMediumTermModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id='formActionMediumTerm' method="post" :action="url" @submit.prevent="validateBeforeSubmit">

                    <div class="modal-content">
                        <div v-html='csrf'></div>

                        <div class="modal-header laravel-modal-bg">
                            <h5 class="modal-title" >{{title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <legend>Estructura del POES</legend>
                            <input type="text" name='id' :value="form.id" v-if="form.id" hidden>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="pilar">Pilar</label>
                                    <input type="text" id="pilar" name="pilar" v-model="form.pilar" class="form-control" placeholder="Pilar" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("pilar") }}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="meta">Meta</label>
                                    <input type="text" id="meta" name="meta" v-model="form.meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("meta") }}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="resultado">Resultado</label>
                                    <input type="text" id="resultado" name="resultado" v-model="form.resultado" class="form-control" placeholder="Resultado" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("resultado") }}</div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="accion">Accion</label>
                                    <input type="text" id="accion" name="accion" v-model="form.accion" class="form-control" placeholder="Accion" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("accion") }}</div>
                                </div>
                            </div>
                            <legend>Accion de Mediano Plazo del PEE</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="code">Numeración</label>
                                    <input type="text" id="code" name="code" v-model="form.code" class="form-control" placeholder="Codigo" v-validate="'required|decimal'" />
                                    <div class="invalid-feedback">{{ errors.first("code") }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="description">Descripcion</label>
                                    <input type="text" id="description" name="description" v-model="form.description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="alcance_meta">Alcance Meta</label>
                                    <input type="text" id="alcance_meta" name="alcance_meta" v-model="form.alcance_meta" class="form-control" placeholder="Alcance Meta" v-validate="'required|decimal:2|min_value:1'" />
                                    <div class="invalid-feedback">{{ errors.first("alcance_meta") }}</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="description">Tipo</label>
                                    <select name="tipo" v-model="form.tipo" class="custom-select" placeholder="Seleccionar" v-validate="'required'" >
                                        <option value="Proceso">Proceso</option>
                                        <option value="Apoyo">Apoyo</option>
                                    </select>
                                    <div class="invalid-feedback">{{ errors.first("tipo") }}</div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="clasificacion">Clasificacion</label>
                                    <select name="clasificacion" v-model="form.clasificacion" class="custom-select" placeholder="Seleccionar" v-validate="'required'" >
                                        <option value="Absoluto">Absoluto</option>
                                        <option value="Relativo">Relativo</option>
                                    </select>
                                    <div class="invalid-feedback">{{ errors.first("clasificacion") }}</div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="resultado_intermedio">Resultado Intermedio</label>
                                    <input type="text" id="resultado_intermedio" name="resultado_intermedio" v-model="form.resultado_intermedio" class="form-control" placeholder="Resultado Intermedio" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("resultado_intermedio") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="linea_base">Linea Base</label>
                                    <input type="text" id="linea_base" name="linea_base" v-model="form.linea_base" class="form-control" placeholder="Linea Base" v-validate="''" />
                                    <div class="invalid-feedback">{{ errors.first("linea_base") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indicador_resultado_intermedio"> Indicador Resultado Intermedio</label>
                                    <input type="text" id="indicador_resultado_intermedio" name="indicador_resultado_intermedio" v-model="form.indicador_resultado_intermedio" class="form-control" placeholder="Resultado Intermedio" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("indicador_resultado_intermedio") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ponderacion"> Ponderacion (%)</label>
                                    <input type="text" id="weighing" name="weighing" v-model="form.weighing" class="form-control" placeholder="Ponderacion" v-validate="'decimal'" />
                                    <div class="invalid-feedback">{{ errors.first("weighing") }}</div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="initial_year">Año inicial</label>
                                    <input type="text" id="initial_year" name="initial_year" v-model="form.initial_year" class="form-control" placeholder="Año inicial" v-validate="'required|numeric'" />
                                    <div class="invalid-feedback">{{ errors.first("initial_year") }}</div>
                                </div>

                            </div>
                            <legend>Estructura Programatica</legend>
							<div class="row">
								<div class="form-group  col-md-4">
									<label for="programatic_structure">Codigo</label>
									<multiselect
										v-model="form.programmatic_structure"
										:options="structures"
										id="programatic_structure"
										placeholder="Seleccionar Codigo"
										select-label="Seleccionar"
										deselect-label="Remover"
										selected-label="Seleccionado"
										label="code"
										track-by="code" >

									</multiselect>
									<div class="invalid-feedback">{{ errors.first("code") }}</div>
								</div>
								<div class="form-group col-md-8 " v-if="form.programmatic_structure" >
									<label for="">Descripcion</label>
									<input type="text" class="form-control" v-model="form.programmatic_structure.description" disabled >
									<input type="text" class="form-control" name='programmatic_structure_id' v-model="form.programmatic_structure.id" hidden>
								</div>
							</div>

                            <div class="row" v-if="parseInt(form.initial_year)>0">
                                <legend>Gestiones</legend>
                                <input type="text" name="gestiones" :value="JSON.stringify(getList)" hidden>
                                <div class="form-group col-md-2" v-for="(year,index) in getList" :key="index" >
                                    <label :for="year.meta">{{year.year}}</label>
                                    <input type="text" :id="year.meta" :name="year.meta" v-model="year.meta" class="form-control" :placeholder="year.year" v-validate="'required|decimal:2'" />
                                    <!-- <div class="invalid-feedback">{{ errors.first(""+year.meta) }}</div>  -->
                                </div>
                                <div class="alert alert-warning col-md-12" role="alert" v-show="subTotalYears==parseFloat(form.alcance_meta)?false:true">
                                    <p v-if="subTotalYears<parseFloat(form.alcance_meta)" >
                                      Falta <strong> {{parseFloat(form.alcance_meta)-subTotalYears}}</strong> para llegar a <strong>Alcance Meta : {{form.alcance_meta}}</strong>
                                    </p>
                                    <p v-else>
                                      Se sobrepaso <strong>{{subTotalYears-parseFloat(form.alcance_meta)}}</strong> de<strong>Alcance Meta : {{form.alcance_meta}}</strong>
                                    </p>
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

// console.log(form);
import Switches from 'vue-switches';
export default {
    props:['url','csrf','structures'],
    data:()=>({
        form:{years:[]},
        title:'',

        // form:null,

    }),
    mounted(){
        console.log('iniciando componente years');
        console.log(this.url);
        console.log(this.structures);
        // this.form =
        // console.log(this.form);
        $('#ActionMediumTermModal').on('show.bs.modal',(event)=> {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var amt = button.data('json') // Extract info from data-* attributes
            // console.log(amt);
            this.title ='Nueva Accion a Mediano Plazo';
            if(amt)
            {
                this.form = amt;
                console.log(this.form);
                this.$set(this.form, 'initial_year', amt.years[0].year);
                // this.form.initial_year = amt.years[0].year;//termina quitando la reactividad averiguar el por que
                //   console.log();
                this.title='Editar '+amt.code;
            }else{
                axios.get('last_amt')
                    .then((response)=>{
                        console.log(response.data);
                        // this.form.code = response.data.code +1;
                        let code =  parseInt(response.data.code)+1;
                        this.form = {code: code,years:[]};
                        console.log(this.form);
                    })



            }

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        })
    },
    methods:{
        validateBeforeSubmit() {
            this.$validator.validateAll().then((result) => {
                if (result) {

                let form = document.getElementById("formActionMediumTerm");
                    if(this.subTotalYears==parseFloat(this.form.alcance_meta)){
                        form.submit();
                    }else{
                        toastr.info(' La Meta de la Accion: '+this.form.alcance_meta+' es distinta a la sumatoria de las Total metas por gestion: '+this.subTotalYears+'');
                    }
                    // console.log(result);
                    return;
                }
                toastr.error('Debe completar los campos requeridos')
            });
        },

        goobye(){
            swal({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "error",
            button: "Aww yiss!",
            });
        },

    },
    computed:{
        getList(){
            if(this.form.years.length==0){
                console.log('creando nuevos elementos');
               for (let i = 0; i < 5; i++) {
                    this.form.years.push({year: parseInt(this.form.initial_year)+i,meta:0});
                }
            }
            let i=0;
            this.form.years.forEach(element => {
                element.year =  parseInt(this.form.initial_year)+i;
                i++;
                 return element;
            });

            return this.form.years;
        },
        subTotalYears(){
            let amount=0;
            this.form.years.forEach(element => {
                 amount+=parseFloat(element.meta);
            });
            if(this.form.clasificacion == "Relativo"){
                amount = amount/this.form.years.length
            }
            return amount;
        },
    },
    components: {
        Switches
    },
}
</script>
