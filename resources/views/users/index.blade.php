@extends('layouts.app')
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
                <div class="card-header card-calendar"> 
                    <h4 class="card-title ">
                        {{$title??''}}
                        <small class="float-sm-right">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#userModal" data-json="null" > Nuevo  <i class="fa fa-plus-circle"></i> </button>
                        </small>
                     </h4>
                </div>

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
    {{-- aqui los modals --}}
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['action' => 'UserController@store']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Datos del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="form-group  col-md-12">
                            {!! Form::label('full_name', 'Nombre Completo')!!}
                            {!! Form::text('full_name',null,['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-12">
                            {!! Form::label('username', 'Usuario')!!}
                            {!! Form::text('username','',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-12">
                            {!! Form::label('password', 'Password')!!}
                            <input type="password" class="form-control" placeholder="" name="password">
                            {{-- {!! Form::password('password','',['class'=>'form-control'])!!} --}}
                        </div>
            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
                    <button type="button" class="btn btn-primary">guardar</button>
                </div>
                {!! Form::close() !!}
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