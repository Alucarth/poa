<template>
    <div class="row">
      <div class="col-md-3">
        <v-date-picker class="elevation-6" v-model="date" type="month" width="250" color="green lighten-1" header-color="card-calendar" locale="es" @input="getData()"></v-date-picker>
      </div>
      <div class="col-md-9">
        <v-card class="elevation-6 ">
            <v-card-title primary-title class="card-calendar">
                <div>
                    <div class="headline">Tareas</div>
                    <span class="grey--text">{{date}}</span>
                </div>
            </v-card-title>
            <v-card-text>
              <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config"  >
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
                    <v-icon @click="edit(props)" data-toggle="modal" data-target="#taskModalExecuted" >
                    edit
                    </v-icon>
                </template>
              </vue-bootstrap4-table>
            </v-card-text>
  
        </v-card> 
      </div>
      <!-- aqui va el modal o dialog mejor dicho de vuetify -->
     <div class="modal fade" id="taskModalExecuted" tabindex="-1" role="dialog" aria-labelledby="taskModalExecutedLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header laravel-modal-bg">
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
      form:null
            
       
    }),
    methods:{
      getData(){
        console.log('evento disparado');
        axios.get(`execution_year/${this.date}`)
             .then((response)=>{
              this.rows = response.data.tasks;
              // console.log(response.data.tasks);
             });
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
                    // this.form = response.data;
                });
      }
    },
    components: {
        VueBootstrap4Table
    }
}
</script>
