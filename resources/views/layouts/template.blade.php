<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MyMoney') }} | @yield('title')</title>
    <!-- Fonts -->
    <link href="{{ asset('tampilan/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Styles -->
    @if(Auth::user()->level === "user")
    <link href="{{ asset('tampilan/css/sb-admin-2.css') }}" rel="stylesheet">
    @else
    <link href="{{ asset('tampilan/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @endif

    <link href="{{ asset('tampilan/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('index')}}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="sidebar-brand-text mx-3">MaMoney</div>
        </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        @if(Auth::user()->level === "user")
        <li class="nav-item {{ Nav::isRoute('dashboard.index') }}">
            <a class="nav-link" href="{{ route('dashboard.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->level === "admin")
        <li class="nav-item {{ Nav::isRoute('admin.index') }}">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard <sup>Admin</sup> </span>
            </a>
        </li>
        @endif
        @if(Auth::user()->level === "user")
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item {{ Nav::isRoute('dashboard.saldo.*') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-wallet"></i>
                <span>Saldo</span>
            </a>
            <div id="collapseTwo" class="collapse {{ Nav::isRoute('dashboard.saldo.*','show') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Nav::isRoute('dashboard.saldo.topup') }}" href="{{route('dashboard.saldo.topup')}}">Topup</a>
                    <a class="collapse-item {{ Nav::isRoute('dashboard.saldo.transfer') }}" href="{{route('dashboard.saldo.transfer')}}">Transfer</a>
                    <a class="collapse-item {{ Nav::isRoute('dashboard.saldo.riwayat') }}" href="{{route('dashboard.saldo.riwayat')}}">Riwayat</a>
                    <a class="collapse-item {{ Nav::isRoute('dashboard.saldo.pengeluaran') }}" href="{{route('dashboard.saldo.pengeluaran')}}">Pengeluaran</a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ Nav::isRoute('dashboard.shop.*') }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                <i class="fas fa-fw fa-store"></i>
                <span>Shop</span>
            </a>
            <div id="collapseThree" class="collapse {{ Nav::isRoute('dashboard.shop.*','show') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Nav::isRoute('dashboard.shop.pulsa') }}" href="{{route('dashboard.shop.pulsa')}}">Pulsa</a>
                    <a class="collapse-item {{ Nav::isRoute('dashboard.shop.listrik') }}" href="{{route('dashboard.shop.listrik')}}">Listrik</a>
                    <a class="collapse-item {{ Nav::isRoute('dashboard.shop.voucher.*') }}" href="{{route('dashboard.shop.voucher.list')}}">Voucher</a>
                </div>
            </div>
        </li>
 
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item {{ Nav::isRoute('dashboard.tabungan.*') }}">
            <a class="nav-link" href="{{ route('dashboard.tabungan.index') }}">
                <i class="fas fa-coins"></i>	
                <span>Tabungan</span>
            </a>
        </li>
        <li class="nav-item {{ Nav::isRoute('dashboard.catatan.*') }}">
            <a class="nav-link" href="{{ route('dashboard.catatan.list') }}">
                <i class="fas fa-sticky-note"></i>
                <span>Catatan</span>
            </a>
        </li>
        <li class="nav-item {{ Nav::isRoute('dashboard.myvoucher') }}">
            <a class="nav-link" href="{{ route('dashboard.myvoucher') }}">
                <i class="fas fa-ticket-alt"></i>
                <span>My Voucher</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->level === "admin")
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            {{ __('Manajemen data') }}
        </div>
        
        <li class="nav-item {{ Nav::isRoute('admin.users.*') }}">
            <a class="nav-link" href="{{ route('admin.users.list') }}">
                <i class="fas fa-users-cog"></i>
                <span>Data Pengguna</span>
            </a>
        </li>
       
        <li class="nav-item {{ Nav::isRoute('admin.voucher.*') }}">
            <a class="nav-link" href="{{ route('admin.voucher.list') }}">
                <i class="fas fa-ticket-alt"></i>
                <span>Data Voucher</span>
            </a>
        </li>
        @endif
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item {{ Nav::isRoute('myaccount.*') }}">
            <a class="nav-link" href="{{ route('myaccount') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Akun Saya</span>
            </a>
        </li>
        
        <li class="nav-item ">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
        <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Topbar Navbar -->
                
                <ul class="navbar-nav ml-auto">
                    @if(Auth::user()->level === "user")
                    <li class="nav-item mx-1">
                        <div class="nav-link">
                            <span>  @currency(Auth::user()->balance) &nbsp;&nbsp; </span>    
                            <i class="fas fa-money-bill-wave"></i> 
                        </div>
                    </li>
                    @endif

                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">2</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('myaccount') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Profile') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Bayu Gusti Paraya 2020</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Yakin ingin keluar dan mengakhiri sesi?</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('tampilan/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('tampilan/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('tampilan/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('tampilan/js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('tampilan/vendor/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('tampilan/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('tampilan/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

@yield('for-script')
</body>
</html>