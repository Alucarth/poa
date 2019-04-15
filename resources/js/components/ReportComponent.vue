<template>

    <div class="row">
        <div class="col-md-auto">
            <v-date-picker class="elevation-6" v-model="months" multiple with="290" type="month" color="green"
                header-color="#00407b" locale="es" @input="getData()">
            </v-date-picker>
        </div>
        <div class="col">
            <v-card class="elevation-6 ">
                <v-card-title primary-title class="card-calendar">

                    <v-layout>
                        <v-flex shrink pa-1>
                            <div class="title">Reporte:</div>
                        </v-flex>
                        <v-flex grow pa-1>
                            <multiselect v-model="tipo" :options="lista" placeholder="Selecionar Tipo" label="name"
                                track-by="name" @select="getData"></multiselect>
                        </v-flex>
                        <v-flex shrink pa-1>
                            <small>
                                <button class="btn btn-success"  data-toggle="modal" data-target="#periodoModal" @click="generarPeriodo()">Periodo</button>
                                <button class="btn btn-success" @click="download">excel</button>
                                <button class="btn btn-info"  @click="downloadPdf()">pdf</button>
                            </small>
                        </v-flex>
                    </v-layout>

                </v-card-title>
                <v-card-text>
                    <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config"
                        @on-select-row="getSelectedRows" @on-unselect-row="getSelectedRows"
                        @on-all-select-rows="getSelectedRows" @on-all-unselect-rows="getSelectedRows">
                        <template slot="sort-asc-icon">
                            <i class="fa fa-sort-asc"></i>
                        </template>
                        <template slot="sort-desc-icon">
                            <i class="fa fa-sort-desc"></i>
                        </template>
                        <template slot="no-sort-icon">
                            <i class="fa fa-sort"></i>
                        </template>

                        <template slot="task_code" slot-scope="props">

                            {{props.row.task_code}}
                            <!-- <v-btn icon> -->
                                <v-icon data-toggle="tooltip" data-placement="bottom" :title="props.row.task_description" small>
                                    fa-question-circle
                                </v-icon>
                            <!-- </v-btn> -->

                    </template>
                    </vue-bootstrap4-table>
                </v-card-text>

            </v-card>
        </div>
        <table id="my-table">
            <!-- ... -->
        </table>
        <div class="modal fade" id="periodoModal" tabindex="-1" role="dialog" aria-labelledby="periodoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="periodoModalLabel">Periodo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-if="periodo">
                            <div class="form-group col-md-9">
                                <label for=""> Meta</label>
                                <input type="text" class="form-control" v-model="periodo.meta" >
                            </div>
                            <div class="form-group col-md-9">
                                <label for=""> Ejecutado</label>
                                <input type="text" class="form-control" v-model="periodo.executed" >
                            </div>
                            <div class="form-group col-md-9">
                                <label for=""> Efficacia</label>
                                <input type="text" class="form-control" v-model="periodo.efficacy" >
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Vista PDF</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="iframe_pdf" frameborder="0" width="100%" height="600"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            months: [],
            columns_base: [{
                    label: "Mes",
                    name: "name",
                    sort: false,
                },
                {
                    label: "Meta",
                    name: "meta",
                    sort: false,
                },
                {
                    label: "Ejecutado",
                    name: "executed",
                    sort: false,
                },
                {
                    label: "Eficacia",
                    name: "efficacy",
                    sort: false,
                },
                {
                    label: "PA",
                    name: "programacion_acumulada",
                    sort: false,
                },
                {
                    label: "EA",
                    name: "ejecucion_acumulada",
                    sort: false,
                },
                {
                    label: "% PA",
                    name: "porcentaje_pa",
                    sort: false,
                },
                {
                    label: "% EA",
                    name: "porcentaje_ea",
                    sort: false,
                },
                {
                    label: "% EEA",
                    name: "eficacia_ejecucion_acumulada",
                    sort: false,
                },

            ],
            columns:[],
            report_list:[],
            rows: [],
            config: {
                card_mode: false,
                checkbox_rows: true,
                rows_selectable: true,
                global_search: {
                    placeholder: "Enter custom Search text",
                    visibility: false,
                    case_sensitive: false
                },
                show_refresh_button: false,
                show_reset_button: false,
            },
            lista: [{
                    id: 1,
                    name: "Accion a Mediano Plazo"
                },
                {
                    id: 2,
                    name: "Años"
                },
                {
                    id: 3,
                    name: "Accion a a Corto Plazo"
                },
                {
                    id: 4,
                    name: "Operaciones"
                },
                {
                    id: 5,
                    name: "Tareas"
                },
                // { id: 5,name:"Tareas Especificas"},
            ],
            tipo: {
                id: 5,
                name: "Tareas"
            },
            items_selececcionados: [],
            periodo: null
        }),
        components: {
            VueBootstrap4Table
        },
        mounted(){
            this.columns =this.columns_base;
        },
        methods: {
            getData() {
                // console.log(this.months);
                if (this.months.length > 0) {
                       let months = [];
                    if (this.tipo) {

                        switch (this.tipo.id) {
                            case 5:
                                months = [];
                                this.months.forEach(item => {
                                    months.push(Number(item.split("-")[1]));
                                });

                                axios.post('report_task', {
                                        months: months.toString()
                                    })
                                    .then((response) => {
                                        // this.rows = response.data.specific_tasks;
                                        // this.rows = this.getRows(response.data,year[0]);
                                        console.log(response.data);
                                        this.getRowsTask(response.data);
                                    });

                            break;
                            case 4:
                                months = [];
                                this.months.forEach(item => {
                                    months.push(Number(item.split("-")[1]));
                                });

                                axios.post('report_operation', {
                                        months: months
                                    })
                                    .then((response) => {
                                        // this.rows = response.data.specific_tasks;
                                        // this.rows = this.getRows(response.data,year[0]);
                                        console.log(response.data);
                                        // this.rows = this.getRows(response.data);
                                    });
                            break;
                            case 3:
                                months = [];
                                this.months.forEach(item => {
                                    months.push(Number(item.split("-")[1]));
                                });

                                axios.post('report_ast', {
                                        months: months
                                    })
                                    .then((response) => {

                                        // console.log(response.data);
                                        this.rows = this.getRows(response.data);
                                    });
                            break;
                            case 2:
                                months = [];
                                this.months.forEach(item => {
                                    months.push(Number(item.split("-")[1]));
                                });

                                axios.post('report_year', {
                                        months: months
                                    })
                                    .then((response) => {

                                        // console.log(response.data);
                                        this.rows = this.getRows(response.data);
                                    });
                            break;
                            case 1:
                                months = [];
                                this.months.forEach(item => {
                                    months.push(Number(item.split("-")[1]));
                                });

                                axios.post('report_amt', {
                                        months: months
                                    })
                                    .then((response) => {

                                        // console.log(response.data);
                                        this.rows = this.getRowsTask(response.data);
                                    });
                            break;
                        }

                    }
                } else {
                    this.rows = [];
                }
            },
            getRowsTask(rows) {

                this.report_list = rows;
                this.columns =[];
                this.columns.push({ label: "Tarea",
                    name: "task_code",
                    sort: false,});
                this.columns_base.forEach(row => {
                    this.columns.push(row);
                });
                console.log(this.columns);
                // let tasks = [];
                // rows.forEach(task => {

                //     task.programmings.forEach(programming => {
                //         programming.task_code = task.code;
                //         programming.task_description = task.description;
                //         programming.task_id = task.id;
                //         tasks.push(programming);
                //     });
                // });
                this.rows = rows;

                // $('[data-toggle="tooltip"]').tooltip();
                // return tasks;
            },
            getRowsOperation(rows) {

                this.report_list = rows;
                this.columns =[];
                this.columns.push({ label: "Tarea",
                    name: "task_code",
                    sort: false,});
                this.columns_base.forEach(row => {
                    this.columns.push(row);
                });
                console.log(this.columns);
                let tasks = [];
                rows.forEach(task => {

                    task.programmings.forEach(programming => {
                        programming.task_code = task.code;
                        programming.task_description = task.description;
                        programming.task_id = task.id;
                        tasks.push(programming);
                    });
                });
                this.rows = tasks;

                // $('[data-toggle="tooltip"]').tooltip();
                // return tasks;
            },
            porcentaje(ejecutado, meta) {
                return numeral((Number(ejecutado) * 100) / Number(meta)).format('0.00') ;
            },

            download: function (event) {
                // `this` inside methods point to the Vue instance
                // self = this;
                let rows = [];
                rows =[];

                this.items_selececcionados.forEach(item => {
                    rows.push(item);
                });
                console.log(rows);
                // rows = this.items_selececcionados;
                let orders_rows = _.sortBy(rows, ['task_id']);
                console.log(orders_rows);
                this.generarPeriodo();
                rows.push(this.periodo);
                //
                let parameters = {};
                parameters['columns'] = JSON.stringify(this.columns);
                console.log(this.columns);
                parameters["rows"] = JSON.stringify(orders_rows);
                parameters["title"] = this.tipo.name.toUpperCase();
                parameters["date"] = moment().format('LLL');
                parameters["format"] = "excel";
                parameters["type"] = this.tipo.id;


                // parameters.excel =true;
                // console.log(parameters);
                axios({
                    url: 'report_excel',
                    method: 'GET',
                    params: parameters,
                    responseType: 'blob', // important
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Reporte ' + moment().format() + '.xls');
                    document.body.appendChild(link);
                    link.click();
                    // self.dialog = false;
                });
            },
            downloadPdf: function (event) {
                // `this` inside methods point to the Vue instance
                // self = this;
               let rows = [];
                rows =[];

                this.items_selececcionados.forEach(item => {
                    rows.push(item);
                });
                console.log(rows);
                // rows = this.items_selececcionados;
                let orders_rows = _.sortBy(rows, ['task_id']);
                console.log(orders_rows);
                this.generarPeriodo();
                rows.push(this.periodo);
                //
                let parameters = {};
                parameters['columns'] = JSON.stringify(this.columns);
                console.log(this.columns);
                parameters["rows"] = JSON.stringify(orders_rows);
                parameters["title"] = this.tipo.name.toUpperCase();
                parameters["date"] = moment().format('LLL');
                parameters["format"] = "pdf";

                // parameters.excel =true;
                // console.log(parameters);
                axios({
                    url: 'report_excel',
                    method: 'GET',
                    params: parameters,
                    responseType: 'blob', // important
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Reporte ' + moment().format() + '.pdf');
                    document.body.appendChild(link);
                    link.click();
                    // self.dialog = false;
                });
            },

            download_pdf() {
                console.log('print pdf');
                // let parameters={};
                // parameters['columns'] =JSON.stringify(this.columns);
                // parameters["rows"] =JSON.stringify(this.rows);
                let head = [];
                let body = [];
                let logo = "data:image/png;base64,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";


                this.columns.forEach(item => {
                    head.push(item.label)
                });

                this.items_selececcionados.forEach(item => {
                    body.push([item.name,item.meta,item.executed,item.efficacy,item.programacion_acumulada,item.ejecucion_acumulada,item.porcentaje_pa,item.porcentaje_ea,item.eficacia_ejecucion_acumulada]);
                });
                console.log("generando pdf");
                this.generarPeriodo();
                body.push([this.periodo.name,this.periodo.meta,this.periodo.executed,this.periodo.efficacy,this.periodo.programacion_acumulada,this.periodo.ejecucion_acumulada,this.periodo.porcentaje_pa,this.periodo.porcentaje_ea,this.periodo.eficacia_ejecucion_acumulada]);

                console.log(head);
                var doc = new jsPDF();
                doc.autoTable({
                    html: '#my-table'
                });
                 doc.setFontSize(10)
                doc.text(''+moment().format('LLL') ,195,15,{align:'right'});
                doc.setFontSize(12)
                let y=25;
                doc.text('EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS',100,y,{align:'center'});
                y+=5;
                doc.text('GERENCIA DE PLANIFICIACION Y DESARROLLO',100,y,{align:'center'});
                y+=5;
                doc.text('REPORTE '+this.tipo.name.toUpperCase() ,100,y,{align:'center'});
                y+=5;

                doc.addImage(logo, 'PNG', 5 , 5)
                // doc.text('EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS','center');
                doc.autoTable({
                    head: [head],
                    body: body,
                    startY: y
                });
                // doc.save('reporte.pdf');
                document.getElementById("iframe_pdf").src = doc.output('datauristring');//Display in iframe

            },

            generarPeriodo() {

                console.log(this.items_selececcionados);
                let meta=0;
                let executed=0;
                this.items_selececcionados.forEach(item => {
                    meta+= Number(item.meta);
                    executed+= Number(item.executed);
                });

                this.periodo = {
                                name:'Periodo',
                                executed:executed,
                                efficacy: this.porcentaje(executed,meta),
                                meta:meta,
                                programacion_acumulada: "",
                                ejecucion_acumulada: "",
                                porcentaje_pa: "",
                                porcentaje_ea: "",
                                eficacia_ejecucion_acumulada: "",
                                };
                // this.rows.forEach(element => {

                // });
            },

            getSelectedRows(rows) {
                this.items_selececcionados = rows.selected_items;
                console.log(rows);
            }
        }
    }

</script>
