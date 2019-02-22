<template>
     <div >
		
       	<legend>Tareas</legend>

	    <div class="row">
		   <div class="d-flex justify-content-center">
				<div class="p-2 ">
					<button type="button" class="btn btn-primary btn-sm " @click="addItem()"> Adicionar Tarea <i class="fa fa-plus-circle"></i> </button>
				</div>
				<div class="p-2">
					<button type="button" class="btn btn-danger btn-sm " @click="removeAll()"> Eliminar Todo <i class="fa fa-trash"></i> </button>
				</div>
				<input type="text" name="tareas" :value="JSON.stringify(tareas)" class="form-control" hidden>
			</div>
		</div>
       
		<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Descripcion</th>
				<th scope="col">Meta</th>
				<!-- <th scope="col">Asignar tareas</th> -->
			</tr>
		</thead>
		<tbody>
			<tr v-for="(tarea,index) in tareas" :key="index">
				
				<td><input type="text" v-model="tarea.descripcion" class="form-control"></td>
				<td><input type="text" v-model="tarea.meta" class="form-control"></td>
				<td>
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-calendar"></i></button>
					<button type="button" class="btn btn-danger btn-sm" @click="removeItem(tarea)"><i class="fa fa-trash"></i></button>
				</td>

				<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
					<div class="modal-header bg-success">
						<h2 class="modal-title" id="exampleModalLabel">2019</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-3"  v-for="(item,index) in getList(tarea)" :key="index">
								<div class="small-box bg-success" >
									<div class="inner">
									<h4>{{item.month}}<sup style="font-size: 15px"></sup></h4>

									<p>{{item.value}}</p>
									</div>
					
									
									<a href="#" class="small-box-footer" @click="item.edit=!item.edit">
									 Adicionar Detalle
									<i class="fa fa-plus-circle"></i>
									</a>
									<transition name="fade">
										<input v-if="item.edit" v-model="item.value" v-on:keyup.enter="item.edit=false" type="text" class="form-control" >
									</transition>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Send message</button>
					</div> -->
					</div>
				</div>
				</div>

			</tr>
			
		</tbody>
		</table>
		
    </div>
</template>

<script>
export default {
    data:()=>({
		tareas:[],
    }),
    mounted(){
		
        this.tareas.push({descripcion:'',meta:'',year:[
												{month:'Enero',value:'',edit:false},
												{month:'Febrero',value:'',edit:false},
												{month:'Marzo',value:'',edit:false},
												{month:'Abril',value:'',edit:false},
												{month:'Mayo',value:'',edit:false},
												{month:'Junio',value:'',edit:false},
												{month:'Julio',value:'',edit:false},
												{month:'Agosto',value:'',edit:false},
												{month:'Septiembre',value:'',edit:false},
												{month:'Octubre',value:'',edit:false},
												{month:'Noviembre',value:'',edit:false},
												{month:'Diciembre',value:'',edit:false}]});
        console.log('cargando componente tareas');
    },
    methods:{
        addItem(){
            this.tareas.push({descripcion:'',meta:'',year:[
												{month:'Enero',value:'',edit:false},
												{month:'Febrero',value:'',edit:false},
												{month:'Marzo',value:'',edit:false},
												{month:'Abril',value:'',edit:false},
												{month:'Mayo',value:'',edit:false},
												{month:'Junio',value:'',edit:false},
												{month:'Julio',value:'',edit:false},
												{month:'Agosto',value:'',edit:false},
												{month:'Septiembre',value:'',edit:false},
												{month:'Octubre',value:'',edit:false},
												{month:'Noviembre',value:'',edit:false},
												{month:'Diciembre',value:'',edit:false}]});
        },
        removeItem(item){
				const index = this.tareas.indexOf(item)
				this.tareas.splice(index, 1)
        },
        removeAll(){
            this.tareas =[];
            this.tareas.push({descripcion:'',meta:''});
		},
		getList(item){
			console.log(item.year);
			return item.year;
		}
    }
}
</script>
<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
