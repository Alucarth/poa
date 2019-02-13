@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">  <h4 class="card-title" > {{'Usuario # '.$user->id}}</h4> </div>
				<div class="card-body">
					<p> <label> Usuario:</label> {{$user->username}} </p>
					<p> <label> Nombre:</label> {{$user->name}} </p>
					<p> <label> Correo Electronico:</label> {{$user->email}} </p>
					<ul class="list-group">
						<li class="list-group-item active">Roles</li>
						@foreach ($user->roles as $role)
						<li class="list-group-item">{{$role->name}}</li>
						@endforeach
						
					  </ul>
				</div>
               
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
	<script>
        // window.onload = function () {
        //     $('#users_table').DataTable();
        //     // $('#calendar').fullCalendar({
        //     //     weekends: false // will hide Saturdays and Sundays
        //     // });
        // };
    </script>    
@endsection