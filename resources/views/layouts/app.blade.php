<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{--
    <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    {{--
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vuetify.css') }}" rel="stylesheet">
</head>

<body class="hold-transition sidebar-collapse sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-laravel border-bottom fixed-top">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- SEARCH FORM -->

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                @hasrole('Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('users') }}" data-toggle="tooltip" data-placement="bottom" title="Gestion de Usuarios">
                        <i class="fa fa-users"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles') }}" data-toggle="tooltip" data-placement="bottom" title="Gestion de Roles">
                        <i class="fa fa-building"></i>
                    </a>
                </li>
                @endhasrole
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                            {{Auth::user()->name}}  <img src="{{Auth::user()->path_avatar?url('../'.substr(Auth::user()->path_avatar,7)):url('/img/user.jpg')}}" class="navbar-img img-circle elevation-2"  alt="User Image">
                    </a>
                    {{-- <div > --}}
                        {{-- <span class="dropdown-item dropdown-header">15 Notifications</span> --}}
                        <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <li class="dropdown-item" id="perfil">
                                <i class="fa fa-user mr-4"></i> Perfil
                                <span class="float-right"></span>
                            </li>
                            <li class="dropdown-item" id="config">
                                <i class="fa fa-cogs mr-4"></i> Configuracion
                                <span class="float-right"></span>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item" id="logout" data-toggle="modal" data-target="#logoutModal">
                                <i class="fa fa-sign-out-alt mr-4"></i> Salir
                                <span class="float-right"></span>
                            </li>
                        </ul>
                        {{-- <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                                <i class="fa fa-user mr-4"></i> Perfil
                            <span class="float-right"></span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-cogs mr-4"></i> 
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-sign-out mr-4"></i> Salir
                        </a> --}}
                        {{-- <div class="dropdown-divider"></div> --}}
                        {{-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
                    {{-- </div> --}}
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-dark-primary">
            <!-- Brand Logo -->
            <a href="#" class="brand-link ">
                <img src="{!!url('/img/logob.png')!!}" alt="Eba Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar ">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
                    <div class="image">
                        <img src="{{Auth::user()->path_avatar?url('../'.substr(Auth::user()->path_avatar,7)):url('/img/user.jpg')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                            <a href="#" class="d-block"> {{Auth::user()->name}}</a>
                           
						{{-- <nav class="mt-2">
                                
								<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
									<!-- Add icons to the links using the .nav-icon class
							   with font-awesome or any other icon font library -->

								<li class="nav-item has-treeview">
									<a href="#" class="nav-link d-block">
										<p>
											{{Auth::user()->name}}
											<i class="right fa fa-angle-left"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<a href="#" class="nav-link">
												<i class="fa fa-user nav-icon"></i>
												<p>Perfil</p>
											</a>
										</li>
										<li class="nav-item">
                                            <a href="{{ route('logout') }}" class="nav-link"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
												<i class="fa fa-sign-out nav-icon"></i>
                                                <p>Salir</p>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
										</li>

									</ul>
								</li>

								</ul>
						</nav> --}}
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
				   with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                {{-- <i class=" nav-icon material-icons" height="42px" width="42px"> event_note </i> --}}
                                <p>
                                    Tareas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('execution_specific_tasks') }}" class="nav-link">
                                <i class="nav-icon far fa-calendar-check"></i>
                                {{-- <i class=" nav-icon material-icons"> event_available </i> --}}
                                <p>
                                    Tareas Especificas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('action_medium_term') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>
                                    Planificacion
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <section class="content-header "style=" padding-top: 60px;">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1> @yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
								@yield('breadcrums')
                                {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Blank Page</li> --}}
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="container-fluid">
             
                <div id="app">
                    @yield('content')
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        {{-- <footer class="main-footer fixed-bottom">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.0.0-alpha
            </div>
            <strong>Copyright &copy; 2019 <a href="http://adminlte.io">EBA</a>.</strong> Todos los derechos reservados.
        </footer> --}}


    </div>
    <!-- Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header laravel-modal-bg">
                    <h5 class="modal-title" id="logoutModalLabel">Cerrar Sesion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Esta seguro de cerrar session ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success"><i class="nav-icon fa fa-sign-out-alt"></i>Si </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
    <script>
        window.onload = function () {
            $('#lista').DataTable();
            var message =@json(session('message'));
            var error = @json(session('error'));
            var info = @json(session('info'));
            if(message){
                toastr.success(message,'Registro Exitoso');
            }
            if(error){
                toastr.error( error,'Error');
            }
            if(info){
                toastr.info(info, 'Alerta' );
            }
            $('#perfil').click(function(){
                console.log('perfil click');
            });
            $('#config').click(function(){
                console.log('config click');
            });
            $('#logout').click(function(){
                console.log('logout click');
            });
            @yield('script')
        };
    </script>
</body>

</html>
