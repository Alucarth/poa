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
                id: 2,
                name: "Años"
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
                       let months = [];
                    if (this.tipo) {

                        switch (this.tipo.id) {
                            case 5:
                                months = [];
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
                                        this.rows = response.data;
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
                                        // this.rows = response.data.specific_tasks;
                                        // this.rows = this.getRows(response.data,year[0]);
                                        console.log(response.data);
                                        this.rows = response.data;
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
                                        // this.rows = response.data.specific_tasks;
                                        // this.rows = this.getRows(response.data,year[0]);
                                        console.log(response.data);
                                        this.rows = response.data;
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
                let logo = "data:image/png;base64,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";


                this.columns.forEach(item => {
                    head.push(item.label)
                });

                this.rows.forEach(item => {
                    body.push([item.name,item.meta,item.executed,item.efficacy,item.programacion_acumulada,item.ejecucion_acumulada,item.porcentaje_pa,item.porcentaje_ea,item.eficacia_ejecucion_acumulada]);
                });
                console.log(head);
                var doc = new jsPDF();
                doc.autoTable({
                    html: '#my-table'
                });
                doc.text(20, 15, 'Reporte: '+this.tipo.name);
                doc.addImage(logo, 'PNG', 170 , 5, 25, 16)
                doc.autoTable({
                    head: [head],
                    body: body
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
