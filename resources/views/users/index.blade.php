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
                                    <a href="{{url('users/'.$user->id)}}" ><i class="material-icons text-info">remove_red_eye</i> </a>
                                    <a href="{{url('users/'.$user->id.'/edit')}}" ><i class="material-icons text-primary">edit</i></a>
                                    <a href="#" ><i class="material-icons text-danger">delete</i></i></a>
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
                {!! Form::open(['action' => 'UserController@store','files' => true]) !!}
                <div class="modal-header card-calendar">
                    <h5 class="modal-title" id="userModalLabel">Datos del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="form-group  col-md-12">
                            {!! Form::label('full_name', 'Nombre')!!}
                            {!! Form::text('full_name',null,['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('email', 'Email')!!}
                            {!! Form::text('email',null,['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-8">
                            {!! Form::label('avatar', 'Imagen: ')!!}
                            {!! Form::file('avatar');!!}
                        </div>
                        <div class="form-group  col-md-6">
                            {!! Form::label('username', 'Usuario')!!}
                            {!! Form::text('username','',['class'=>'form-control'])!!}
                        </div>
                        <div class="form-group  col-md-6">
                            {!! Form::label('password', 'Password')!!}
                            <input type="password" class="form-control" placeholder="" name="password">
                            {{-- {!! Form::password('password','',['class'=>'form-control'])!!} --}}
                        </div>

                    </div>
              
                    <div class="row">
                        <div class="form-group  col-md-6">
                            {!! Form::label('rol', 'Roles')!!}
                            <ul class="list-group">
                                @foreach ($roles as $role)
                                <li class="list-group-item ">{{$role->name}} <small class="float-sm-right"><input type="checkbox" class="js-switch" name='roles[]' value="{{$role->name}}" /></small>  </li>
                                @endforeach
                                
                            </ul>
                            
                            {{-- {!! Form::select('rol_id', $roles,null,['class'=>'custom-select'])!!} --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
                    <button type="submit" class="btn btn-primary">guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    
</div>
@endsection
<script>
@section('script')
	
    $('#users_table').DataTable();
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html,{ size: 'small' });
    });
    // var elem =document.querySelector('.js-switch');
    // var init = new Switchery(elem, { size: 'small' });
          
@endsection
</script>    