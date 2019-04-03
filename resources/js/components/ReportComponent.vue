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
                rows.forEach(item => {
                    day.month(item.month_id-1);
                    columns.push({month:day.format('MMMM')+'-'+year,meta:item.month_meta,executed:item.month_executed,efficacy:this.porcentaje(item.month_executed,item.month_meta)});
                });
                return columns;
            },
            porcentaje(ejecutado,meta){
                return numeral((Number(ejecutado) * 100)/Number(meta)).format('0.00')+' %';
            }

        }
    }

</script>
