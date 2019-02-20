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
    {{--
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- SEARCH FORM -->
            {{-- <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> --}}

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->

               
				{{-- <li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link"> <i class="fa fa-users"></i> </a>
				</li> --}}
                <li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
								<img src="/img/user2-160x160.jpg" class="img-circle " alt="User Image" style="height: 2vw; width: 2vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<span class="dropdown-item dropdown-header"> <strong>{{ Auth::user()->name}}</strong> </span>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fa fa-user mr-2"></i> Editar Perfil
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fa fa-sign-out mr-2"></i> Cerrar Sesion
							</a>
							
							
						</div>
					</li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="/img/logosedem.png" alt="EBA Logo" class="brand-image img-circle  elevation-3 " style="height: 2vw; width: 2vw;opacity: .8">
                <span class="brand-text font-weight-light"> {{ config('app.name', 'Laravel') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
					</div>
			
                    <div class="info">

                    <a href="#" class="d-block">{{ Auth::user()->name}}</a>
                    </div>
                </div>
			
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
					   with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-pie-chart"></i>
                                <p>
                                    Programacion
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="pages/charts/chartjs.html" class="nav-link">
                                        <i class="fa fa-calendar-o nav-icon"></i>
                                        <p>Corto Plazo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pages/charts/flot.html" class="nav-link">
                                        <i class="fa fa-calendar nav-icon"></i>
                                        <p>Largo Plazo</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fa  fa-list"></i>
                                <p>
                                    Asignacion de Tareas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fa fa-shield"></i>
                                <p>
                                    Efectividad de Accion
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v2</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
					{{-- <footer class="main-footer">
						<strong>Copyright &copy; 2014-2018 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
						All rights reserved.
						<div class="float-right d-none d-sm-inline-block">
							<b>Version</b> 3.0.0-alpha
						</div>
					</footer> --}}
        <!-- /.content-wrapper -->


    </div>
    <!-- ./wrapper -->
    @yield('script')
</body>

</html>
