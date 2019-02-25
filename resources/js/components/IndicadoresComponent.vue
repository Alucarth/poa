<template>
    <div >
		
       	<legend>Indicadores</legend>

	    <div class="row">
		   <div class="d-flex justify-content-center">
				<div class="p-2 ">
					<button type="button" class="btn btn-primary btn-sm " @click="addItem()"> Adicionar Indicador <i class="fa fa-plus-circle"></i> </button>
				</div>
				<div class="p-2">
					<button type="button" class="btn btn-danger btn-sm " @click="addItem()"> Eliminar Todo <i class="fa fa-trash"></i> </button>
				</div>
				<input type="text" name="indicadores" :value="JSON.stringify(indicadores)" class="form-control" hidden>
			</div>
		</div>
       
		<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Descripcion</th>
				<th scope="col">Unidad</th>
				<th scope="col">Linea Base</th>
				<th scope="col">Meta</th>
				<th scope="col">Producto Esperado</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(indicador,index) in indicadores" :key="index">
				
				<td><input type="text" v-model="indicador.descripcion" class="form-control"></td>
				<td><input type="text" v-model="indicador.unidad" class="form-control"></td>
				<td><input type="text" v-model="indicador.linea_base" class="form-control"></td>
				<td><input type="number" step="any" v-model="indicador.meta" class="form-control"></td>
				<td><input type="text" v-model="indicador.producto_esperado" class="form-control"></td>
				<td><button type="button" class="btn btn-danger btn-sm" @click="removeItem(indicador)"><i class="fa fa-trash"></i></button></td>
			</tr>
			
		</tbody>
		</table>

    </div>
</template>

<script>
    export default {
        data:()=>({
            indicadores:[]
        }),
        mounted() {
			console.log('Componente Indicadores XD')
			this.indicadores.push({descripcion:'',unidad:'',linea_base:'',meta:'',producto_esperado:''});
		},
		methods:{
			addItem(){
				this.indicadores.push({descripcion:'',unidad:'',linea_base:'',meta:'',producto_esperado:''});
			},
			removeItem(item){
				const index = this.indicadores.indexOf(item)
				this.indicadores.splice(index, 1)
			},
			removeAll(){
				this.indicadores =[];
				this.indicadores.push({descripcion:'',unidad:'',linea_base:'',meta:'',producto_esperado:''});
			}
		}
    }
</script>