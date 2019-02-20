@extends('layouts.adminlte')
@section('title')
    {{$title}}
@endsection
@section('breadcrums')
{{ Breadcrumbs::render('users') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">  <h4 class="card-title" > {{$title}}</h4> </div>

                <div class="card-body">
                    <table id="users_table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $user)
                            <tr>
                                <td>{{$user->username}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td> 
                                    <a href="{{url('users/'.$user->id)}}" class="btn btn-info"> <i class="fa fa-eye"></i> </a>
                                    <a href="{{url('users/'.$user->id.'/edit')}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>  
                            @endforeach
                            </tbody>
                        
                    </table> 

          
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
	<script>
        window.onload = function () {
            $('#users_table').DataTable();
            // $('#calendar').fullCalendar({
            //     weekends: false // will hide Saturdays and Sundays
            // });
        };
    </script>    
@endsection