@extends('layouts.app')
@section('title')
    {{$title}}
@endsection
@section('breadcrums')
{{ Breadcrumbs::render('roles') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-calendar">  <h4 class="card-title" > {{$title}}</h4> </div>
				
                <div class="card-body">
                    
						<table id="rol_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach($roles as $rol)
                                <tr>
									<td>{{$rol->name}}</td>
									<td>{{$rol->description}}</td>
                                    <td> <i class="fa fa-eye"></i> <i class="fa fa-pencil"></i>  <i class="fa fa-trash"></i> </td>
								</tr>  
								@endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Opciones</th>
                                </tr>
                            </tfoot>
                        </table> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
@section('script')
        
            $('#rol_table').DataTable();
     
@endsection
</script>    