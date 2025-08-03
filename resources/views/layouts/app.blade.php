<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" 
                                   aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                    </li>
                                </ul>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
