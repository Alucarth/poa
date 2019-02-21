<template>
     <div >
		
       	<legend>Operaciones</legend>

	    <div class="row">
		   <div class="d-flex justify-content-center">
				<div class="p-2 ">
					<button type="button" class="btn btn-primary btn-sm " @click="addItem()"> Adicionar Indicador <i class="fa fa-plus-circle"></i> </button>
				</div>
				<div class="p-2">
					<button type="button" class="btn btn-danger btn-sm " @click="addItem()"> Eliminar Todo <i class="fa fa-trash"></i> </button>
				</div>
				<input type="text" name="operaciones" :value="JSON.stringify(operaciones)" class="form-control">
			</div>
		</div>
       
		<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Descripcion</th>
				<th scope="col">Asignar tareas</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(operacion,index) in operaciones" :key="index">
				
				<td><input type="text" v-model="operacion.descripcion" class="form-control"></td>
				<td><button type="button" class="btn btn-danger btn-sm" @click="removeItem(operacion)"><i class="fa fa-trash"></i></button></td>
			</tr>
			
		</tbody>
		</table>

    </div>
</template>

<script>
export default {
    data:()=>({
        operaciones:[]
    }),
    mounted(){
        this.operaciones.push({operaciones:''});
        console.log('cargando componente Operaciones');
    },
    methods:{
        addItem(){
            this.operaciones.push({operaciones:''});
        },
        removeItem(item){
				const index = this.operaciones.indexOf(item)
				this.operaciones.splice(index, 1)
        },
        removeAll(){
            this.operaciones =[];
            this.operaciones.push({descripcion:''});
        }
    }
}
</script>
