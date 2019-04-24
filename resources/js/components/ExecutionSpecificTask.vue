<template>
    <div class="row">

      <div class="col-md-auto">
          <v-date-picker class="elevation-6" v-model="date" with="290" type="month" color="green" locale="es"
              @input="getData()">
          </v-date-picker>
      </div>
      <div class="col">
          <v-card class="elevation-6 ">
              <v-card-title primary-title class="card-calendar">
                  <div>
                      <div class="headline">Tareas Especificas </div>
                      <span class="white--text">{{date}}</span>
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

                        <template slot="efficacy" slot-scope="props">
                           <span :class="getColor(props.row.efficacy)">{{props.row.efficacy}}</span>
                        </template>



                      <template slot="option" slot-scope="props">
                          <v-icon @click="getDetail(props)" data-toggle="modal" data-target="#taskModalDetail"
                              small>
                              remove_red_eye
                          </v-icon>
                          <v-icon @click="edit(props)" data-toggle="modal" data-target="#taskModalExecuted"
                              small>
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
            <div class="modal-header card-calendar">
              <h5 class="modal-title " id="taskModalExecutedLabel" v-if="form">Ejecucion de Tarea del Mes  </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" v-if="form">
              <!-- <form> -->
                <legend>Tarea Especifica</legend>
                <div class="form-group">
                  <label for="meta" class="col-form-label">Meta:</label>
                  <input type="text" class="form-control" id="meta" v-model='form.specific_task.meta'>
                </div>
                <div class="form-group">
                  <label for="executed" class="col-form-label">Ejecucion:</label>
                  <input type="text" class="form-control" id="executed"  v-model='form.specific_task.executed' >
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
                      <a class="list-group-item list-group-item-action" id="list-year-list" data-toggle="list" href="#list-year" role="tab" aria-controls="year"><i class="fa fa-clock"></i> {{detail.year.year}}</a>
                      <a class="list-group-item list-group-item-action" id="list-ast-list" data-toggle="list" href="#list-ast" role="tab" aria-controls="ast"><i class="fa fa-calendar-alt"></i> {{detail.action_short_term.code}}</a>
                      <a class="list-group-item list-group-item-action" id="list-operation-list" data-toggle="list" href="#list-operation" role="tab" aria-controls="operation"><i class="fa fa-clipboard-list"></i> {{detail.operation.code}}</a>
                      <a class="list-group-item list-group-item-action" id="list-task-list" data-toggle="list" href="#list-task" role="tab" aria-controls="task"><i class="fa fa-calendar-week"></i> {{detail.task.code}}</a>
                      <a class="list-group-item list-group-item-action active" id="list-specific-list" data-toggle="list" href="#list-specific" role="tab" aria-controls="specific"><i class="fa fa-calendar-day"></i> {{detail.specific_task.code}}</a>
                      <a class="list-group-item list-group-item-action " id="list-graphics-list" data-toggle="list" href="#list-graphics" role="tab" aria-controls="graphics"><i class="fa fa-chart-line"></i> Progreso</a>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-amt" role="tabpanel"
                            aria-labelledby="list-home-list">
                            <legend>Accion a Mediano Plazo {{detail.action_medium_term.code}}</legend>
                            <p> Descripcion:<strong> {{detail.action_medium_term.description}}</strong> </p>
                            <v-chip color="green  " text-color="white">
                                <v-avatar class="green darken-4">
                                    <v-icon color="white">flag</v-icon>
                                </v-avatar>
                                Meta: {{detail.action_medium_term.alcance_meta}}
                            </v-chip>
                            <br>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>fa-calendar-check</v-icon>
                                </v-avatar>
                                Ejecucion: {{detail.action_medium_term.executed}}
                            </v-chip>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-3">
                                    <v-icon color="white" small>perm_data_setting</v-icon>
                                </v-avatar>
                                Eficacia: {{getFormaNumber(detail.action_medium_term.efficacy)+' %'}}
                            </v-chip>
                        </div>
                        <div class="tab-pane fade" id="list-year" role="tabpanel" aria-labelledby="list-year-list">
                            <legend>Gestion {{detail.year.year}}</legend>

                            <v-chip color="green  " text-color="white">
                                <v-avatar class="green darken-3">
                                    <v-icon color="white">flag</v-icon>
                                </v-avatar>
                                Meta: {{detail.year.meta}}
                            </v-chip>
                            <br>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-3">
                                    <v-icon color="white" small>fa-calendar-check</v-icon>
                                </v-avatar>
                                Ejecucion: {{detail.year.excecuted}}
                            </v-chip>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>perm_data_setting</v-icon>
                                </v-avatar>
                                Eficacia: {{getFormaNumber(detail.year.efficacy)+' %'}}
                            </v-chip>
                        </div>
                        <div class="tab-pane fade" id="list-ast" role="tabpanel" aria-labelledby="list-ast-list">
                            <legend>Accion a Corto Plazo {{detail.action_short_term.code}}</legend>
                            <p> Descripcion:<strong> {{detail.action_short_term.description}}</strong> </p>
                            <v-chip color="green  " text-color="white">
                                <v-avatar class="green darken-4">
                                    <v-icon color="white">flag</v-icon>
                                </v-avatar>
                                Meta: {{detail.action_short_term.meta}}
                            </v-chip>
                            <br>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>fa-calendar-check</v-icon>
                                </v-avatar>
                                Ejecucion: {{detail.action_short_term.executed}}
                            </v-chip>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>perm_data_setting</v-icon>
                                </v-avatar>
                                Eficacia: {{getFormaNumber(detail.action_short_term.efficacy)+' %'}}
                            </v-chip>
                        </div>
                        <div class="tab-pane fade" id="list-operation" role="tabpanel"
                            aria-labelledby="list-operation-list">
                            <legend>Operacion {{detail.operation.code}}</legend>
                            <p> Descripcion:<strong> {{detail.operation.description}}</strong> </p>
                            <v-chip color="green  " text-color="white">
                                <v-avatar class="green darken-4">
                                    <v-icon color="white">flag</v-icon>
                                </v-avatar>
                                Meta: {{detail.operation.meta}}
                            </v-chip>
                            <br>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>fa-calendar-check</v-icon>
                                </v-avatar>
                                Ejecucion: {{detail.operation.executed}}
                            </v-chip>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>perm_data_setting</v-icon>
                                </v-avatar>
                                Eficacia: {{getFormaNumber(detail.operation.efficacy)+' %'}}
                            </v-chip>
                        </div>
                        <div class="tab-pane fade" id="list-task" role="tabpanel" aria-labelledby="list-task-list">
                            <legend>Tarea {{detail.task.code}}</legend>
                            <p> Descripcion:<strong> {{detail.task.description}}</strong> </p>
                            <v-chip color="green  " text-color="white">
                                <v-avatar class="green darken-4">
                                    <v-icon color="white">flag</v-icon>
                                </v-avatar>
                                Meta: {{detail.task.meta}}
                            </v-chip>
                            <br>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>fa-calendar-check</v-icon>
                                </v-avatar>
                                Ejecucion: {{detail.task.executed}}
                            </v-chip>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>perm_data_setting</v-icon>
                                </v-avatar>
                                Eficacia: {{getFormaNumber(detail.task.efficacy)+' %'}}
                            </v-chip>
                        </div>
                        <div class="tab-pane fade" id="list-specific" role="tabpanel"
                            aria-labelledby="list-specific-list">
                            <legend>Tarea Especifica {{detail.specific_task.code}}</legend>
                            <p> Descripcion:<strong> {{detail.specific_task.description}}</strong> </p>
                            <v-chip color="green  " text-color="white">
                                <v-avatar class="green darken-4">
                                    <v-icon color="white">flag</v-icon>
                                </v-avatar>
                                Meta: {{detail.specific_task.meta}}
                            </v-chip>
                            <br>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>fa-calendar-check</v-icon>
                                </v-avatar>
                                Ejecucion: {{detail.specific_task.executed}}
                            </v-chip>
                            <v-chip color=" blue  " text-color="white">
                                <v-avatar class="blue darken-4">
                                    <v-icon color="white" small>perm_data_setting</v-icon>
                                </v-avatar>
                                Eficacia: {{getFormaNumber(detail.specific_task.efficacy)+' %'}}
                            </v-chip>
                        </div>
                         <div class="tab-pane fade" id="list-graphics" role="tabpanel" aria-labelledby="list-graphics-list">
                            <legend>Detalle</legend>
                            <canvas id="chartAst" ></canvas>
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
var chart=null;
import VueBootstrap4Table from 'vue-bootstrap4-table';
export default {
     props:['alerts'],
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
        detail:null,
        config_chart :{
            type: 'bar',
            data: [],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            min:0,
                            max:100,
                        }
                    }]
                }
            }
        },



    }),
    mounted(){
      this.getData();
      console.log(this.alerts);
    },
    methods:{
      getData(){
        console.log('evento disparado');
        axios.get(`execution_specific_task/${this.date}`)
             .then((response)=>{
              this.rows = response.data.specific_tasks;
              console.log(response.data);
             });
      },
      getFormaNumber(number){
        return numeral(number).format('0.00');
      },
      edit(item)
      {
        console.log(item);
          axios.get(`execution_specific_task/${item.row.id}/edit`)
               .then((response)=>{
                  // this.rows = response.data.tasks;
                console.log(response.data);
                this.form = response.data;
                this.dialog = true;
             });
        // this.dialog=true;
      },
      storeItem(){
           axios.post('specific_task_store',this.form)
                .then((response)=>{
                      // this.rows = response.data.tasks;
                    console.log(response.data);
                    this.dialog = false;
                    this.getData();
                    toastr.success('Calculo de eficacia exitoso','Se Actualizo');

                    // this.form = response.data;
                });
      },
      getDetail(item){

        // console.log(item);
        axios.get(`specific_task_show/${item.row.id}`)
             .then((response)=>{
               this.detail = response.data;
               this.graficar(response.data);
               console.log(response.data);
             });
      },
      getColor(value){
          let textColor="text-black";
          this.alerts.forEach(color => {
            if(value >= color.min && value <= color.max)
            {
                console.log(value+' color:'+color.color);
                textColor = "text-"+color.color;
                //return color.color;
                // break;
            }
          });
        return textColor;
        },
         graficar(detail)
      {
            $(document).ready(()=>{



                let labels = [];
                let efficacys = [];
                let colors = [];

                labels.push(detail.action_medium_term.code);
                efficacys.push(detail.action_medium_term.efficacy);
                colors.push(this.getColorExa(detail.action_medium_term.efficacy));

                labels.push(detail.year.year+'');
                efficacys.push(detail.year.efficacy);
                colors.push(this.getColorExa(detail.year.efficacy));

                labels.push(detail.action_short_term.code);
                efficacys.push(detail.action_short_term.efficacy);
                colors.push(this.getColorExa(detail.action_short_term.efficacy));

                labels.push(detail.operation.code);
                efficacys.push(detail.operation.efficacy);
                colors.push(this.getColorExa(detail.operation.efficacy));

                labels.push(detail.task.code);
                efficacys.push(detail.task.efficacy);
                colors.push(this.getColorExa(detail.task.efficacy));

                labels.push(detail.specific_task.code);
                efficacys.push(detail.specific_task.efficacy);
                colors.push(this.getColorExa(detail.specific_task.efficacy));

                let data = {
                    labels: labels,
                    datasets: [{
                        label: '% de Eficacia',
                        data: efficacys,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 1
                    }]
                };

                this.config_chart.data = data;
                // console.log(this.config_chart);
                let ctx = document.getElementById('chartAst');
                console.log(ctx);
                if(chart){
                    chart.update();
                    console.log('renderizando');
                }else{
                    chart = new Chart(ctx,this.config_chart);
                }
            });
        },
        getColorExa(value){
            let colorx="#000000";
            this.alerts.forEach(color => {
                if(value >= color.min && value <= color.max)
                {
                    // console.log(value+' color:'+color.color);
                    switch (color.color) {
                        case 'danger':
                            colorx ='#EC0043';
                            break;

                        case 'warning':
                            colorx ='#FFCE00';
                            break;

                        case 'success':
                            colorx ='#00B345';
                            break;

                    }

                    //return color.color;
                    // break;
                }
            });
            return colorx;
        }
    },
    components: {
        VueBootstrap4Table
    }
}
</script>
