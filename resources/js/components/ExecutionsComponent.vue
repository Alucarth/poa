<template>
    <div >
      <v-container grid-list-xl>
          <v-layout row>
              <v-flex>
                  <v-date-picker class="elevation-6" 
                      v-model="date"
                      with="290"
                      type="month"
                      color="green"
                      header-color="#00407b"
                      locale="es"
                      @input="getData()">
                  </v-date-picker>
              </v-flex>
              <v-flex>
                  <v-card class="elevation-6 ">
                      <v-card-title primary-title class="card-calendar">
                          <div>
                              <div class="headline">Tareas</div>
                              <span class="grey--text">{{date}}</span>
                          </div>
                      </v-card-title>
                      <v-card-text>
                          <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config">
                              <template slot="sort-asc-icon">
                                  <i class="fa fa-sort-asc"></i>
                              </template>
                              <template slot="sort-desc-icon">
                                  <i class="fa fa-sort-desc"></i>
                              </template>
                              <template slot="no-sort-icon">
                                  <i class="fa fa-sort"></i>
                              </template>

                              <template slot="option" slot-scope="props">
                                  <v-icon @click="getDetail(props)" data-toggle="modal" data-target="#taskModalDetail" small>
                                      remove_red_eye
                                  </v-icon>
                                  <v-icon @click="edit(props)" data-toggle="modal" data-target="#taskModalExecuted" small>
                                      edit
                                  </v-icon>
                              </template>
                          </vue-bootstrap4-table>
                      </v-card-text>

                  </v-card>
              </v-flex>
          </v-layout>
      </v-container>
    
      <!-- aqui va el modal o dialog mejor dicho de vuetify -->
     <div class="modal fade" id="taskModalExecuted" tabindex="-1" role="dialog" aria-labelledby="taskModalExecutedLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header card-calendar">
              <h5 class="modal-title " id="taskModalExecutedLabel" v-if="form">Ejecucion de Tarea Programada {{form.task.code}} </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" v-if="form">
              <!-- <form> -->
                <legend>Programacion</legend>
                <div class="form-group">
                  <label for="meta" class="col-form-label">Meta:</label>
                  <input type="text" class="form-control" id="meta" v-model='form.programming.meta'>
                </div>
                <div class="form-group">
                  <label for="executed" class="col-form-label">Ejecucion:</label>
                  <input type="text" class="form-control" id="executed"  v-model='form.programming.executed' >
                </div>
              
              <!-- </form> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" @click='dialog=false' >cancelar</button>
              <button type="button" class="btn btn-success" data-dismiss="modal" @click="storeItem()">Guardar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- modal detalle -->
      <div class="modal fade" id="taskModalDetail" tabindex="-1" role="dialog" aria-labelledby="taskModalDetailLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header card-calendar">
              <h5 class="modal-title " id="taskModalDetailLabel" v-if="detail">Detalle de Tarea {{detail.task.code}} </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" v-if="detail">
              <!-- <form> -->
                <div class="row">
                  <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                      <a class="list-group-item list-group-item-action " id="list-amt-list" data-toggle="list" href="#list-amt" role="tab" aria-controls="amt"> <i class="fa fa-calendar"></i> {{detail.action_medium_term.code}}</a>
                      <a class="list-group-item list-group-item-action" id="list-year-list" data-toggle="list" href="#list-year" role="tab" aria-controls="year"><i class="fa fa-clock-o"></i> {{detail.year.year}}</a>
                      <a class="list-group-item list-group-item-action" id="list-ast-list" data-toggle="list" href="#list-ast" role="tab" aria-controls="ast"><i class="fa fa-calendar-plus-o"></i> {{detail.action_short_term.code}}</a>
                      <a class="list-group-item list-group-item-action" id="list-operation-list" data-toggle="list" href="#list-operation" role="tab" aria-controls="operation"><i class="fa fa-list-alt"></i> {{detail.operation.code}}</a>
                      <a class="list-group-item list-group-item-action active" id="list-task-list" data-toggle="list" href="#list-task" role="tab" aria-controls="task"><i class="fa fa-tasks"></i> {{detail.task.code}}</a>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                      <div class="tab-pane fade show active" id="list-amt" role="tabpanel" aria-labelledby="list-home-list">
                        <legend>Accion a Mediano Plazo {{detail.action_medium_term.code}}</legend>
                        <p> Descripcion:<strong> {{detail.action_medium_term.description}}</strong>  </p>
                        <v-chip color="green  " text-color="white">
                          <v-avatar class="green darken-4"> <v-icon color="white">flag</v-icon> </v-avatar>
                          Meta: {{detail.action_medium_term.alcance_meta}}
                        </v-chip>
                        <br>
                        <v-chip color=" blue  " text-color="white">
                          <v-avatar class="blue darken-4"> <v-icon color="white" small>fa-calendar-check-o</v-icon> </v-avatar>
                          Ejecucion: {{detail.action_medium_term.executed}}
                        </v-chip>
                        <v-chip color=" blue  " text-color="white">
                          <v-avatar class="blue darken-3"> <v-icon color="white" small>perm_data_setting</v-icon> </v-avatar>
                          Eficacia: {{getFormaNumber(detail.action_medium_term.efficacy)+' %'}}
                        </v-chip>
                      </div>
                      <div class="tab-pane fade" id="list-year" role="tabpanel" aria-labelledby="list-year-list">
                        <legend>Gestion {{detail.year.year}}</legend>
  
                        <v-chip color="green  " text-color="white">
                          <v-avatar class="green darken-3"> <v-icon color="white">flag</v-icon> </v-avatar>
                          Meta: {{detail.year.meta}}
                        </v-chip>
                        <br>
                        <v-chip color=" blue  " text-color="white">
                          <v-avatar class="blue darken-3"> <v-icon color="white" small>fa-calendar-check-o</v-icon> </v-avatar>
                          Ejecucion: {{detail.year.excecuted}}
                        </v-chip>
                        <v-chip color=" blue  " text-color="white">
                          <v-avatar class="blue darken-4"> <v-icon color="white" small>perm_data_setting</v-icon> </v-avatar>
                          Eficacia: {{getFormaNumber(detail.year.efficacy)+' %'}}
                        </v-chip>
                      </div>
                      <div class="tab-pane fade" id="list-ast" role="tabpanel" aria-labelledby="list-ast-list">
                        <legend>Accion a Corto Plazo {{detail.action_short_term.code}}</legend>
                        <p> Descripcion:<strong> {{detail.action_short_term.description}}</strong>  </p>
                        <v-chip color="green  " text-color="white">
                          <v-avatar class="green darken-4"> <v-icon color="white">flag</v-icon> </v-avatar>
                          Meta: {{detail.action_short_term.meta}}
                        </v-chip>
                        <br>
                        <v-chip color=" blue  " text-color="white">
                          <v-avatar class="blue darken-4"> <v-icon color="white" small>fa-calendar-check-o</v-icon> </v-avatar>
                          Ejecucion: {{detail.action_short_term.executed}}
                        </v-chip>
                        <v-chip color=" blue  " text-color="white">
                          <v-avatar class="blue darken-4"> <v-icon color="white" small>perm_data_setting</v-icon> </v-avatar>
                          Eficacia: {{getFormaNumber(detail.action_short_term.efficacy)+' %'}}
                        </v-chip>
                      </div>
                      <div class="tab-pane fade" id="list-operation" role="tabpanel" aria-labelledby="list-operation-list">
                          <legend>Operacion {{detail.operation.code}}</legend>
                          <p> Descripcion:<strong> {{detail.operation.description}}</strong>  </p>
                          <v-chip color="green  " text-color="white">
                            <v-avatar class="green darken-4"> <v-icon color="white">flag</v-icon> </v-avatar>
                            Meta: {{detail.operation.meta}}
                          </v-chip>
                          <br>
                          <v-chip color=" blue  " text-color="white">
                            <v-avatar class="blue darken-4"> <v-icon color="white" small>fa-calendar-check-o</v-icon> </v-avatar>
                            Ejecucion: {{detail.operation.executed}}
                          </v-chip>
                          <v-chip color=" blue  " text-color="white">
                            <v-avatar class="blue darken-4"> <v-icon color="white" small>perm_data_setting</v-icon> </v-avatar>
                            Eficacia: {{getFormaNumber(detail.operation.efficacy)+' %'}}
                          </v-chip>
                      </div>
                      <div class="tab-pane fade" id="list-task" role="tabpanel" aria-labelledby="list-task-list">
                          <legend>Tarea {{detail.task.code}}</legend>
                          <p> Descripcion:<strong> {{detail.task.description}}</strong>  </p>
                          <v-chip color="green  " text-color="white">
                            <v-avatar class="green darken-4"> <v-icon color="white">flag</v-icon> </v-avatar>
                            Meta: {{detail.task.meta}}
                          </v-chip>
                          <br>
                          <v-chip color=" blue  " text-color="white">
                            <v-avatar class="blue darken-4"> <v-icon color="white" small>fa-calendar-check-o</v-icon> </v-avatar>
                            Ejecucion: {{detail.task.executed}}
                          </v-chip>
                          <v-chip color=" blue  " text-color="white">
                            <v-avatar class="blue darken-4"> <v-icon color="white" small>perm_data_setting</v-icon> </v-avatar>
                            Eficacia: {{getFormaNumber(detail.task.efficacy)+' %'}}
                          </v-chip>
                      </div>
                    </div>
                  </div>
              </div>
                            
              <!-- </form> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" >cerrar</button>
              <!-- <button type="button" class="btn btn-success" data-dismiss="modal" @click="storeItem()">Guardar</button> -->
            </div>
          </div>
        </div>
      </div>

    </div>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
export default {
	 data: () => ({
      date: new Date().toISOString().substr(0, 7),
      search: '',
      rows: [],
      columns: [{
              label: "Cod.",
              name: "code",
              filter: {
                  type: "simple",
                  placeholder: "Cod."
              },
              sort: true,
          },
          {
              label: "Descripcion",
              name: "description",
              filter: {
                  type: "simple",
                  placeholder: "Descripcion"
              },
              sort: true,
          },
          {
              label: "Meta",
              name: "meta",
              filter: {
                  type: "simple",
                  placeholder: "Meta"
              },
              sort: true,
          },
          {
              label: "Ejecucion",
              name: "executed",
              filter: {
                  type: "simple",
                  placeholder: "Ejecucion"
              },
              sort: true,
          },
          {
              label: "Eficacia",
              name: "efficacy",
              filter: {
                  type: "simple",
                  placeholder: "Eficacia"
              },
              sort: true,
          },
        
          {
              label: "Opcion",
              name: "option",
              sort: false,
          }],
      config: {
          card_mode: false,
          checkbox_rows: false,
          rows_selectable: false,
          global_search:  {
                placeholder:  "Enter custom Search text",
                visibility: false,
                case_sensitive:  false
          },
          show_refresh_button:  false,
          show_reset_button:  false,
      },
      dialog:false,
      form:null,
      detail:null
            
       
    }),
    mounted(){
      this.getData();
    },
    methods:{
      getData(){
        console.log('evento disparado');
        axios.get(`execution_year/${this.date}`)
             .then((response)=>{
              this.rows = response.data.tasks;
              // console.log(response.data.tasks);
             });
      },
      getFormaNumber(number){
        return numeral(number).format('0.00');
      },
      edit(item)
      {
        console.log(item);
          axios.get(`executions/${item.row.programming_id}/edit`)
               .then((response)=>{
                  // this.rows = response.data.tasks;
                console.log(response.data);
                this.form = response.data;
                this.dialog = true;
             });
        // this.dialog=true;
      },
      storeItem(){
           axios.post('executions',{programming_id:this.form.programming.id,executed:this.form.programming.executed})
                .then((response)=>{
                      // this.rows = response.data.tasks;
                    console.log(response.data);
                    this.dialog = false;
                    this.getData();
                    toastr.success(response.data.task.code,'Se Actualizo');

                    // this.form = response.data;
                });
      },
      getDetail(item){
        
        // console.log(item);
        axios.get(`executions/${item.row.programming_id}`)
             .then((response)=>{
               this.detail = response.data;
               console.log(response.data);
             });
      }
    },
    components: {
        VueBootstrap4Table
    }
}
</script>
