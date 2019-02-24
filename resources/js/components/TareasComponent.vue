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
				<td><input type="number" step="any" v-model="tarea.meta" class="form-control"></td>
				<td>
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="loadProgramings(tarea)"><i class="fa fa-calendar"></i></button>
					<button type="button" class="btn btn-danger btn-sm" @click="removeItem(tarea)"><i class="fa fa-trash"></i></button>
				</td>

				

			</tr>
			
		</tbody>
		</table>
		
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
						<div class="col-md-3"  v-for="(item,index) in months" :key="index">
							<div :class="item.value.length>0?'small-box bg-primary':'small-box bg-success'" >
								<div class="inner">
								<h4>{{item.name}}<sup style="font-size: 15px"></sup></h4>

								<span>{{item.value}}</span>
								</div>
				
								<a href="#" class="small-box-footer" @click="item.edit=!item.edit" >
									Adicionar Detalle
								<i :class="item.edit==true?'fa fa-arrow-circle-up':'fa fa-arrow-circle-down'"></i>
								</a>
								<transition  name="fade">
									<input v-if="item.edit" v-model="item.value" v-on:keyup.enter="item.edit=false" type="text" class="form-control" >
								</transition>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary"  data-dismiss="modal" @click="saveProgramings()">Guardar</button>
				</div>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
export default {
	props:['meses'],
    data:()=>({
		tareas:[],
		indexEdit:-1,
		tareaEdit:{},
		months:[],
    }),
    mounted(){
		
		this.meses.forEach(month => {
			month.edit =false;
			month.value ='';
		});
		// this.cleanCalendar();
		this.months = this.meses;//asignacion este siempre tiene que ser declarado en el data por la reactividad XD
		console.log(this.months);
        this.tareas.push({descripcion:'',meta:'',programaciones:[]});
        console.log('cargando componente tareas');
    },
    methods:{
        addItem(){
            this.tareas.push({descripcion:'',meta:'',programaciones:[]});
        },
        removeItem(item){
				const index = this.tareas.indexOf(item)
				this.tareas.splice(index, 1)
        },
        removeAll(){
            this.tareas =[];
            this.tareas.push({descripcion:'',meta:''});
		},
		loadProgramings(tarea){ //carga las tareas al calendario
			this.cleanCalendar();
			// this.months=this.meses;
			this.indexEdit = this.tareas.indexOf(tarea);
			this.tareaEdit = tarea;
			console.log(tarea);
			// console.log(this.tareaEdit);
			// let mes_tarea = tarea.programaciones.find((mes)=>{return mes.id == 2 });
			// console.log(mes_tarea);
			this.months.forEach((month) => {
				// console.log(tarea);
				let month_id=month.id;
				let mes_tarea = mes_tarea = tarea.programaciones.find((mes)=>{return mes.id == month_id });
				console.log(mes_tarea)
				if(mes_tarea){
					month.value =mes_tarea.value;
				}
			});
		},
		saveProgramings(){
			// let programaciones =  _.find(this.months, function(o) { return o.value.length >=0; });
			let meses = _.filter(this.months, (o)=> { return o.value.length >0; });
			let programaciones=[];
			meses.forEach( mes => {
				programaciones.push({id:mes.id,name:mes.name,edit:mes.edit,value:mes.value})
			});
			let tarea = this.tareaEdit;
			tarea.programaciones = programaciones;
			Object.assign(this.tareas[this.indexEdit], tarea)
			console.log(this.tareas);
		},
		cleanCalendar(){
			this.months.forEach(month => {
				month.value='';
			});
		},
	

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
