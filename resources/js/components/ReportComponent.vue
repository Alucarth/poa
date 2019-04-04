<template>

<div class="row">
    <div class="col-md-auto">
        <v-date-picker class="elevation-6" v-model="months" multiple with="290" type="month"
                color="green"
                header-color="#00407b" locale="es"
            @input="getData()">
        </v-date-picker>
    </div>
    <div class="col">
        <v-card class="elevation-6 ">
            <v-card-title primary-title class="card-calendar">
                <div>
                    <div class="headline">Reporte </div>
                    <span class="white--text"></span>
                    <button class="btn btn-success" @click="download">excel</button>
                    <button class="btn btn-info" @click="download_pdf">pdf</button>
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

</div>
</template>
<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table';
    export default {
        data: () => ({
            months: [],
            columns: [
            {
              label: "Mes",
              name: "month",
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
            }
            ],
            rows:[],
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
        }),
        components: {
            VueBootstrap4Table
        },

        methods:{
            getData(){
                // console.log(this.months);
                if(this.months.length > 0){

                    let year =  this.months[0].split("-");
                    let months =[];
                    this.months.forEach(item => {
                        months.push(Number(item.split("-")[1])) ;
                    });
                    let query={year:year[0],months:months.toString()};
                    // console.log(query);
                    // console.log(months.toString());
                    axios.post('report',query)
                        .then((response)=>{
                        // this.rows = response.data.specific_tasks;
                        this.rows = this.getRows(response.data,year[0]);
                        console.log(response.data);
                    });
                }else{
                    this.rows=[];
                }
            },
            getRows(rows,year)
            {
                console.log(year);
                let day = moment();
                let columns=[];
                let total_executed =0;
                let total_meta =0;
                rows.forEach(item => {
                    day.month(item.month_id-1);
                    columns.push({month:day.format('MMMM')+'-'+year,meta:item.month_meta,executed:item.month_executed,efficacy:this.porcentaje(item.month_executed,item.month_meta)});
                    total_executed += Number(item.month_executed);
                    total_meta += Number(item.month_meta);
                });
                columns.push({month:'Periodo',meta:numeral(total_meta).format('0.00'),executed:numeral(total_executed).format('0.00'),efficacy:this.porcentaje(total_executed,total_meta)});
                return columns;
            },
            porcentaje(ejecutado,meta){
                return numeral((Number(ejecutado) * 100)/Number(meta)).format('0.00')+' %';
            },

            downloadExcel(){
                let params = {columns:this.columns,rows:this.rows}
                axios.post('report_excel',params)
                    .then((response)=>{
                        console.log(response.data);
                    });
            },
            download: function (event) {
            // `this` inside methods point to the Vue instance
            // self = this;
            //
                let parameters={};
                parameters['columns'] =JSON.stringify(this.columns);
                parameters["rows"] =JSON.stringify(this.rows);

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
                    link.setAttribute('download', 'Reporte '+moment().format()+'.xls');
                    document.body.appendChild(link);
                    link.click();
                    // self.dialog = false;
                });
            },
            download_pdf: function (event) {
            // `this` inside methods point to the Vue instance
            // self = this;
            //
                let parameters={};
                parameters['columns'] =JSON.stringify(this.columns);
                parameters["rows"] =JSON.stringify(this.rows);

                // parameters.excel =true;
                // console.log(parameters);
                axios({
                    url: 'report_pdf',
                    method: 'GET',
                    params: parameters,
                    responseType: 'blob', // important
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Reporte '+moment().format()+'.pdf');
                    document.body.appendChild(link);
                    link.click();
                    // self.dialog = false;
                });
            },


        }
    }

</script>
