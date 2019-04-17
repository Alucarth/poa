<template>
    <div class="row">
        <div class="col-md-6">
            <v-card>

            <v-card-title>
                <div>
                    <span>Actividades a Mediano plazo Mes gestion:&nbsp;  </span>
                </div>
                    <span class="float-right">
                        <select class="form-control form-control-sm" v-model="year_selected" @click="amtConfig()">
                            <option  v-for="(year,index) in years" :key="index"  >{{year.year}}</option>
                        </select>
                        <!-- {{year_selected}} -->
                    </span>
            </v-card-title>
            <v-card-text>
            <canvas id="chartAmt" ></canvas>
            </v-card-text>

            </v-card>
        </div>
        <div class="col-md-6">
            <v-card>

            <v-card-title>
                <div>
                    <span>Actividades a Corto plazo gestion:&nbsp;  </span>
                </div>
                    <span class="float-right">
                        <select class="form-control form-control-sm" v-model="year_selected_ast" @click="astConfig()">
                            <option  v-for="(year,index) in years" :key="index"  >{{year.year}}</option>
                        </select>
                        <!-- {{year_selected}} -->
                    </span>
            </v-card-title>
            <v-card-text>
            <canvas id="chartAst" ></canvas>
            </v-card-text>

            </v-card>
        </div>
    </div>
</template>
<script>
var chart_asm=null;
var chart_ast=null;
export default {
    props: ['alerts'],
    data:()=>({
        years: [],
        year_selected: 2019,
        year_selected_ast: 2019,
        config_asm :{
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
        config_ast :{
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

        chart_asm:null
    }),
    mounted(){

        this.amtConfig();
        console.log(this.config_asm);

        this.astConfig();
       this.getYears();
    },
    methods:{
        async getYears(){
            // let years=[];
            this.years = await axios.get('years_list').then(response=>{return response.data});
            // coturn years;
        },

        async amtConfig(){

            let amts=[];
            amts = await axios.get(`amt_year/${this.year_selected}`).then(response=>{return response.data});
            console.log(amts);

            let labels = [];
            let efficacys = [];
            let colors = [];

            amts.forEach(item => {
                labels.push(item.name);
                if(!item.month_executed){
                    item.month_executed = 0;
                }
                let efficacy = this.porcentaje(item.month_executed,item.month_meta);
                efficacys.push(efficacy);
                colors.push(this.getColor(efficacy));
            });

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

            this.config_asm.data = data;

            let ctx = document.getElementById('chartAmt');
            if(chart_asm){
                chart_asm.update();
                console.log('renderizando');
            }else{
                chart_asm = new Chart(ctx,this.config_asm);
            }
            // chart_asm?chart_asm.update():chart_asm = new Chart(ctx,this.config_asm);

        },
        async astConfig(){

            let asts=[];
            asts = await axios.get(`ast_year/${this.year_selected_ast}`).then(response=>{return response.data});
            console.log(asts);

            let labels = [];
            let efficacys = [];
            let colors = [];

            asts.forEach(item => {
                labels.push(item.code);
                if(!item.efficacy){
                    item.efficacy = 0;
                }
                let efficacy = item.efficacy;
                efficacys.push(efficacy);
                colors.push(this.getColor(efficacy));
            });

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

            this.config_ast.data = data;

            let ctx = document.getElementById('chartAst');
            if(chart_ast){
                chart_ast.update();
                console.log('renderizando');
            }else{
                chart_ast = new Chart(ctx,this.config_ast);
            }
            // chart_asm?chart_asm.update():chart_asm = new Chart(ctx,this.config_asm);

        },
        porcentaje(ejecutado, meta) {
            return numeral((Number(ejecutado) * 100) / Number(meta)).format('0.00') ;
        },
        getColor(value){
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

    }
}
</script>
