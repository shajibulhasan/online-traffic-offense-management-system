<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @guest
                        <span>Laravel</span>
                    @elseif(Auth::check() && Auth::user()->division_lead != null)
                        <span>Division Leader</span>
                    @elseif(Auth::check() && Auth::user()->district_lead != null)
                        <span>District Leader</span>
                    @elseif(Auth::check() && Auth::user()->thana_lead != null)
                        <span>Thana Leader</span>
                    @elseif(Auth::check() && Auth::user()->area_lead != null)
                        <span>Traffic Officer</span>
                    @elseif(Auth::check() && Auth::user()->role == 'officer')
                        <span>Officer</span>
                    @else
                        <span>User</span>
                    @endguest
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @guest
                        @elseif(Auth::check() && Auth::user()->division_lead != null)
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.assignDistrict') }}">Assign District</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.assignDistrictList') }}">Assign District List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.verifyOfficerAccount') }}">Verify Officer Account</a>
                        </li>
                        @elseif(Auth::check() && Auth::user()->district_lead != null)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.assignThana') }}">Assign Thana</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.show-assign-thana') }}">Assign Thana List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.addThana') }}">Add Thana</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.thanaList') }}">Thana List</a>
                        </li>                        
                        @elseif(Auth::check() && Auth::user()->thana_lead != null)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.assignOfficer') }}">Assign Officer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.assignOfficerList') }}">Assign Officer List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.addArea') }}">Add Area</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Admin.areaList') }}">Area List</a>
                        </li>                    
                        @elseif(Auth::check() && Auth::user()->area_lead != null)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Officer.addOffense') }}">Add Offense</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Officer.offenseList') }}">Offense List</a>
                        </li>
                        @endguest
                    </ul>
                        

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
