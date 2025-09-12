<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Traffic_Offense_Management_System') }}</title>

    <!-- Bootstrap 5 CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('assets/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="{{ route('Admin.index') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"></i>Offense <br> Management</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="ms-3 text-white">
                        @if(Auth::check() && Auth::user()->division_lead != null)
                            <span>Division Lead</span>
                        @elseif(Auth::check() && Auth::user()->district_lead != null)
                            <span>District Lead</span>
                        @elseif(Auth::check() && Auth::user()->thana_lead != null)
                            <span>Thana Lead</span>
                        @elseif(Auth::check() && Auth::user()->area_lead != null)
                            <span>Area Lead</span>
                        @elseif(Auth::check() && Auth::user()->role == 'officer')
                            <span>Officer</span>
                        @else
                            <span>User</span>
                        @endif
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    
                    <a href="{{ route('Admin.index') }}" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    @if(Auth::check() && Auth::user()->division_lead != null)
                    <a href="{{ route('Admin.assignDistrict') }}" class="nav-item nav-link text-white"><i class="fa fa-user me-2"></i>Assign District</a>
                    <a href="{{ route('Admin.assignDistrictList') }}" class="nav-item nav-link text-white"><i class="fa fa-list me-2"></i>Assign District List</a>
                    <a href="{{ route('Admin.verifyOfficerAccount') }}" class="nav-item nav-link text-white"><i class="fa fa-check me-2"></i>Verify Officer</a>

                    @elseif(Auth::check() && Auth::user()->district_lead != null)
                    <a href="{{ route('Admin.assignThana') }}" class="nav-item nav-link text-white"><i class="fa fa-user me-2"></i>Assign Thana</a>
                    <a href="{{ route('Admin.show-assign-thana') }}" class="nav-item nav-link text-white"><i class="fa fa-list me-2"></i>Assign Thana List</a>
                    <a href="{{ route('Admin.addThana') }}" class="nav-item nav-link text-white"><i class="fa fa-plus me-2"></i>Add Thana</a>
                    <a href="{{ route('Admin.thanaList') }}" class="nav-item nav-link text-white"><i class="fa fa-list me-2"></i>Thana List</a>

                    @elseif(Auth::check() && Auth::user()->thana_lead != null)
                    <a href="{{ route('Admin.assignOfficer') }}" class="nav-item nav-link text-white"><i class="fa fa-user me-2"></i>Assign Officer</a>
                    <a href="{{ route('Admin.assignOfficerList') }}" class="nav-item nav-link text-white"><i class="fa fa-list me-2"></i>Assign Officer List</a>
                    <a href="{{ route('Admin.addArea') }}" class="nav-item nav-link text-white"><i class="fa fa-plus me-2"></i>Add Area</a>
                    <a href="{{ route('Admin.areaList') }}" class="nav-item nav-link text-white"><i class="fa fa-list me-2"></i>Area List</a>

                    @elseif(Auth::check() && Auth::user()->area_lead != null)
                    <a href="{{ route('Officer.addOffense') }}" class="nav-item nav-link text-white"><i class="fa fa-plus me-2"></i>Add Offense</a>
                    <a href="{{ route('Officer.offenseList') }}" class="nav-item nav-link text-white"><i class="fa fa-list me-2"></i>Offense List</a>
                    @elseif(Auth::check() && Auth::user()->role == 'user')
                    <a href="{{ route('User.index') }}" class="nav-item nav-link text-white"><i class="fa fa-user me-2"></i>My Offense</a>
                    @endif

                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-inline-flex text-white">{{ Auth::user()->name }}</span>                        
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0" >
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a  href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


        <main class="py-4 container">
            @yield('content')
        </main>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>

</html>