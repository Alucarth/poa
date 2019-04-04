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
                                track-by="name"></multiselect>
                        </v-flex>
                        <v-flex shrink pa-1>
                            <small>
                                <button class="btn btn-success"  data-toggle="modal" data-target="#periodoModal" @click="generarPeriodo()">Periodo</button>
                                <button class="btn btn-success" @click="download">excel</button>
                                <button class="btn btn-info" @click="download_pdf">pdf</button>
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

                        <!-- <template slot="option" slot-scope="props">
                        <v-icon @click="getDetail(props)" data-toggle="modal" data-target="#taskModalDetail"
                            small>
                            remove_red_eye
                        </v-icon>
                        <v-icon @click="edit(props)" data-toggle="modal" data-target="#taskModalExecuted"
                            small>
                            edit
                        </v-icon>
                    </template> -->
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
    </div>
</template>
<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table';

    export default {
        data: () => ({
            months: [],
            columns: [{
                    label: "Nombre",
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
                    name: "Accion a a Corto Plazo"
                },
                // { id: 1,name:"Año"},
                {
                    id: 3,
                    name: "Operaciones"
                },
                {
                    id: 4,
                    name: "Tareas"
                },
                // { id: 5,name:"Tareas Especificas"},
            ],
            tipo: {
                id: 4,
                name: "Tareas"
            },
            items_selececcionados: [],
            periodo: null
        }),
        components: {
            VueBootstrap4Table
        },

        methods: {
            getData() {
                // console.log(this.months);
                if (this.months.length > 0) {

                    if (this.tipo) {

                        switch (this.tipo.id) {
                            case 4:
                                let months = [];
                                this.months.forEach(item => {
                                    months.push(Number(item.split("-")[1]));
                                });

                                axios.post('report_task', {
                                        months: months
                                    })
                                    .then((response) => {
                                        // this.rows = response.data.specific_tasks;
                                        // this.rows = this.getRows(response.data,year[0]);
                                        console.log(response.data);
                                        this.rows = response.data;
                                    });

                                break;
                        }
                        // let year =  this.months[0].split("-");
                        // let months =[];
                        // this.months.forEach(item => {
                        //     months.push(Number(item.split("-")[1])) ;
                        // });
                        // let query={year:year[0],months:months.toString()};
                        // // console.log(query);
                        // // console.log(months.toString());
                        // axios.post('report',query)
                        //     .then((response)=>{
                        //     // this.rows = response.data.specific_tasks;
                        //     this.rows = this.getRows(response.data,year[0]);
                        //     console.log(response.data);
                        // });
                    }
                } else {
                    this.rows = [];
                }
            },
            getRows(rows, year) {
                console.log(year);
                let day = moment();
                let columns = [];
                let total_executed = 0;
                let total_meta = 0;
                let pa = 0; //programacion acumuladaq
                let ea = 0; //ejecucion acumulada
                let ejecutado_periodo = 0;
                let meta_periodo = 0;
                let ppa = 0;
                let pea = 0;
                let eea = 0;
                rows.forEach(item => {
                    ejecutado_periodo += Number(item.month_executed);
                    meta_periodo += Number(item.month_meta);
                });

                rows.forEach(item => {
                    day.month(item.month_id - 1);
                    ppa = pa / meta_periodo;
                    pea = ea / ejecutado_periodo;
                    pa += Number(item.month_meta);
                    ea += Number(item.month_executed);
                    eea = ea / pa;
                    columns.push({
                        month: day.format('MMMM') + '-' + year,
                        meta: item.month_meta,
                        executed: item.month_executed,
                        efficacy: this.porcentaje(item.month_executed, item.month_meta),
                        programacion_acumulada: pa,
                        ejecucion_acumulada: ea,
                        porcentaje_pa: ppa,
                        porcentaje_ea: pea,
                        eficacia_ejecucion_acumulada: eea

                    });
                    total_executed += Number(item.month_executed);
                    total_meta += Number(item.month_meta);
                });
                columns.push({
                    month: 'Periodo',
                    meta: numeral(total_meta).format('0.00'),
                    executed: numeral(total_executed).format('0.00'),
                    efficacy: this.porcentaje(total_executed, total_meta)
                });
                return columns;
            },
            porcentaje(ejecutado, meta) {
                return numeral((Number(ejecutado) * 100) / Number(meta)).format('0.00') + ' %';
            },

            downloadExcel() {
                let params = {
                    columns: this.columns,
                    rows: this.rows
                }
                axios.post('report_excel', params)
                    .then((response) => {
                        console.log(response.data);
                    });
            },
            download: function (event) {
                // `this` inside methods point to the Vue instance
                // self = this;
                //
                let parameters = {};
                parameters['columns'] = JSON.stringify(this.columns);
                parameters["rows"] = JSON.stringify(this.rows);

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
            download_pdf() {
                console.log('print pdf');
                // let parameters={};
                // parameters['columns'] =JSON.stringify(this.columns);
                // parameters["rows"] =JSON.stringify(this.rows);
                let head = [];
                let body = [];
                this.columns.forEach(item => {
                    head.push(item.label)
                });

                this.columns.forEach(item => {
                    body.push(item);
                });
                console.log(head);
                var doc = new jsPDF();
                doc.autoTable({
                    html: '#my-table'
                });
                doc.text(80, 20, 'Reporte');
                doc.autoTable({
                    head: [head],
                    body: []
                });
                doc.save('reporte.pdf');

            },

            generarPeriodo() {

                console.log(this.items_selececcionados);
                let meta=0;
                let executed=0;
                this.items_selececcionados.forEach(item => {
                    meta+= Number(item.meta);
                    executed+= Number(item.executed);
                });

                this.periodo = {meta:meta,executed:executed,efficacy: this.porcentaje(executed,meta)};
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
