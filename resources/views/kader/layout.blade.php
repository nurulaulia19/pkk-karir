<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('admin/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />

    <!-- DataTables -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"/> --}}
    <link rel="stylesheet" href="{{ url('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Favicons -->
    <link href="{{ url('image/remove.png') }}" rel="icon" />
    <link href="{{ url('image/remove.png') }}" rel="apple-touch-icon" />

    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ url('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('admin/plugins/jqvmap/jqvmap.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('admin/dist/css/adminlte.min.css') }}" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('admin/plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('admin/plugins/summernote/summernote-bs4.css') }}" />
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    {{-- Dashboard --}}
    <link rel="stylesheet" href="{{ url('css/dashboard.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .nav-pills .nav-link.active {
            background-color: #50A3B9 !important;
            /* Ganti warna sesuai dengan keinginan */
            color: white !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed" style="height:100% margin: 0; padding: 0;">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                {{-- <span class="brand-text font-weight-dark">Selamat Datang Kader Dasawisma {{ (Auth::user()->name) }} </span> --}}
                <ul class="navbar-nav ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title" style="justify-content:center; display:flex">
                                            {{ Auth::user()->name }}
                                        </h3>
                                        <div class="container" style="justify-content:center; display:flex">
                                            @if (Auth::user()->user_type === 'admin_kabupaten')
                                                <p class="text-sm">Admin Kabupaten</p>
                                            @elseif(Auth::user()->user_type === 'admin_kecamatan')
                                                <p class="text-sm">Admin Kecamatan</p>
                                            @elseif(Auth::user()->user_type === 'admin_desa')
                                                <p class="text-sm">Admin Desa</p>
                                            @elseif(Auth::user()->user_type === 'kader_dasawisma')
                                                <p class="text-sm">Kader Dasawisma</p>
                                            @else
                                                <p class="text-sm">Peran Pengguna tidak dikenali</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media d-flex" style="align-items: center">
                                    <i class="far fa-user"></i>
                                    <a href="/profil">
                                        <h3 class="dropdown-item-title" style="margin-right:200px; width:150px">
                                            Akun Saya
                                        </h3>

                                    </a>
                                </div>
                                <!-- Message End -->
                            </a>
                        </div>
                    </li>
                </ul>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #446d6d">
            <!-- Brand Logo -->
            <a href="/dashboard_kader" class="brand-link">
                <img src="{{ url('image/remove.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: 0.8" />
                <span class="brand-text font-weight-light" style="font-size: 17px">Kader Dasawisma <br> <span
                        style="margin-left:56px">{{ Auth::user()->name }}</span></span><br>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="/dashboard_kader" class="d-block">Desa {{ Auth::user()->desa->nama_desa }} </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="/dashboard_kader"
                                class="nav-link {{ Request::is('dashboard_kader*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item has-treeview {{ Request::is('data_warga*', 'data_keluarga', 'data_rumah_tangga*', 'data_kegiatan*', 'data_pemanfaatan*', 'data_industri*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ Request::is('data_warga*', 'data_keluarga', 'data_rumah_tangga*', 'data_kegiatan*', 'data_pemanfaatan*', 'data_industri*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Pendataan Keluarga <br> dan Kegiatan Warga
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/data_warga"
                                        class="nav-link {{ Request::is('data_warga*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Warga</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/data_keluarga"
                                        class="nav-link {{ Request::is('data_keluarga') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Keluarga</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="/data_rumah_tangga"
                                        class="nav-link {{ Request::is('data_rumah_tangga*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Rumah Tangga</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/data_kegiatan"
                                        class="nav-link {{ Request::is('data_kegiatan*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Kegiatan Warga</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/data_pemanfaatan"
                                        class="nav-link {{ Request::is('data_pemanfaatan*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Pemanfaatan Tanah <br> Pekarangan Keluarga</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/data_industri"
                                        class="nav-link {{ Request::is('data_industri*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Industri Rumah <br>Tangga Keluarga</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/catatan_keluarga"
                                class="nav-link {{ Request::is('catatan_keluarga') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>Rekap Catatan Keluarga</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kader_dasawisma.logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                Keluar
                            </a>
                            <form id="logout-form" action="{{ route('kader_dasawisma.logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </li>


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        {{-- <div class="content-wrapper" style="background-image:  url('{{ asset('assets/img/background.jpg') }}'); background-size: contain; background-position: center; background-repeat: no-repeat; min-height:100vh; background-attachment: fixed;"> --}}
        <!-- Content Header (Page header) -->
        <div class="content-wrapper"
           style="background-image:  url('{{ asset('assets/img/background.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh; padding-bottom: 20px;">
            {{-- <div style="background-color: rgba(0, 0, 0, 0.1); height: 100vh;"> --}}
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                {{-- <h1>@yield('bread')</h1> --}}
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/dashboard_kader">Home</a></li>
                                    <li class="breadcrumb-item active">@yield('bread')</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                @yield('container')
            {{-- </div> --}}
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; Kader Dasawisma.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                {{-- <b>Version</b> 3.0.5 --}}
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ url('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('admin/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('admin/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('admin/dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('admin/dist/js/demo.js') }}"></script>
    <!-- DataTables -->
    {{-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ url('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript"></script>

    @stack('script-addon')
    @include('sweetalert::alert')

    @yield('script')

</body>

</html>
