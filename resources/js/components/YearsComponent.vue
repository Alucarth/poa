<template>
    <div>
        <div class="row">
            <div class="form-group col-md-6">
            <label> Alcance Meta </label>
            <input type="text" class="form-control">
            </div>
            <div class="form-group col-md-6">
            <label> Año base </label>
            <input type="number" step="any" v-model="years" class="form-control" >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
            <label> Alcance Meta </label>
            <input type="text" class="form-control">
            </div>
        </div>
    </div>

    
</template>
<script>
export default {
    data:()=>({
        years:[],
        year_base:2019,
    }),
    mounted(){
        console.log('iniciando componente years');
    },
    conputed:{
        getList(){
            let year={year:this.year_base};
            for (let i = 0; i < 5; i++) {
                
                // this.years      
            }
        }
    }
}
</script>
