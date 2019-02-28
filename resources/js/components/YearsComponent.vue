
<template>
<div>
        <div class="modal fade" id="ActionMediumTermModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id='formActionMediumTerm' method="post" :action="url" @submit.prevent="validateBeforeSubmit">
                    
                    <div class="modal-content">
                        <div v-html='csrf'></div>
                
                        <div class="modal-header laravel-modal-bg">
                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <legend>Estructura del POES</legend>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="pilar">Pilar</label>
                                    <input type="text" id="pilar" name="pilar" v-model="pilar" class="form-control" placeholder="Pilar" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("pilar") }}</div> 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="meta">Meta</label>
                                    <input type="text" id="meta" name="meta" v-model="meta" class="form-control" placeholder="Meta" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("meta") }}</div> 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="resultado">Resultado</label>
                                    <input type="text" id="resultado" name="resultado" v-model="resultado" class="form-control" placeholder="Resultado" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("resultado") }}</div> 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="accion">Accion</label>
                                    <input type="text" id="accion" name="accion" v-model="accion" class="form-control" placeholder="Accion" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("accion") }}</div> 
                                </div>
                            </div>
                            <legend>Accion de Mediano Plazo del PEE</legend>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="description">Descripcion</label>
                                    <input type="text" id="description" name="description" v-model="description" class="form-control" placeholder="Descripcion" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("description") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="description">Tipo</label>
                                    <select name="tipo" v-model="tipo" class="custom-select" placeholder="Seleccionar" v-validate="'required'" >
                                    <option value="Proceso">Proceso</option>
                                    <option value="Apoyo">Apoyo</option>
                                    </select>
                                    <div class="invalid-feedback">{{ errors.first("tipo") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="resultado_intermedio">Resultado Intermedio</label>
                                    <input type="text" id="resultado_intermedio" name="resultado_intermedio" v-model="resultado_intermedio" class="form-control" placeholder="Resultado Intermedio" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("resultado_intermedio") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="linea_base">Linea Base</label>
                                    <input type="text" id="linea_base" name="linea_base" v-model="linea_base" class="form-control" placeholder="Linea Base" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("linea_base") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="indicador_resultado_intermedio"> Indicador Resultado Intermedio</label>
                                    <input type="text" id="indicador_resultado_intermedio" name="indicador_resultado_intermedio" v-model="indicador_resultado_intermedio" class="form-control" placeholder="Resultado Intermedio" v-validate="'required'" />
                                    <div class="invalid-feedback">{{ errors.first("indicador_resultado_intermedio") }}</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="alcance_meta">Alcance Meta</label>
                                    <input type="text" id="alcance_meta" name="alcance_meta" v-model="alcance_meta" class="form-control" placeholder="Alcance Meta" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("alcance_meta") }}</div> 
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="initial_year">Año inicial</label>
                                    <input type="text" id="initial_year" name="initial_year" v-model="initial_year" class="form-control" placeholder="Año inicial" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first("initial_year") }}</div> 
                                </div>
                                
                            </div>
                            <div class="row">
                                <!-- <div class="form-group col-md-4" v-for="(year,index) in getList()" :key="index" >
                                    <label :for="year.year">{{year.year}}</label>
                                    <input type="text" :id="year.year" :name="year.year" v-model="year.meta" class="form-control" :placeholder="year.year" v-validate="'required|decimal:2'" />
                                    <div class="invalid-feedback">{{ errors.first(year.year) }}</div> 
                                </div>     -->
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
export default {
    props:['url','csrf'],
    data:()=>({
        years:[],
        initial_year:2019,
        pilar:0,
        meta:0,
        resultado:0,
        accion:0,
        description:'',
        tipo:'',
        indicador_resultado_intermedio:'',
        alcance_meta:0,
        resultado_intermedio:0,
        linea_base:'',
        
        // form:null,

    }),
    mounted(){
        console.log('iniciando componente years');
        console.log(this.url);
        // this.form = 
        // console.log(this.form);
    },
    methods:{
        validateBeforeSubmit() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                // eslint-disable-next-line
                 let form = document.getElementById("formActionMediumTerm");
                    console.log(form);
                    form.submit();
                    // console.log(result);
                return;
                }

                toastr.error('Debe llenar todos los campos solicitados')
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
        getList(){
            //revisar XD
            this.years =[];
            for (let i = 0; i < 5; i++) {
                this.years.push({year:this.initial_year+i,meta:0});      
            }
            return this.years;
        }
    },
    conputed:{
        
    }
}
</script>
