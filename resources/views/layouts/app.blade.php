<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg- shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item">
                             <a class="nav-link" href="{{ route('Admin.index') }}">{{ __('Admin-Dashboard') }}</a>
                        </li>
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                DivisionLead
                                </a>
                                <ul class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li> <a class="dropdown-item" href="{{ route('Admin.assign-district') }}">{{ __('AssignDistrict') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Admin.assign-district-list') }}">{{ __('AssignDistrictList') }}</a></li>
                                </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   DistrictLead
                                </a>
                                <ul class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li> <a class="dropdown-item" href="{{ route('Admin.assign-thana') }}">{{ __('AssignThana') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Admin.show-assign-thana') }}">{{ __('AssignThanaList') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Admin.addThana') }}">{{ __('AddThana') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Admin.thanaList') }}">{{ __('ThanaList') }}</a></li>
                                </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   ThanaLead
                                </a>
                                <ul class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li> <a class="dropdown-item" href="{{ route('Admin.assign-officer') }}">{{ __('AssignOfficer') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Admin.assign-officer-list') }}">{{ __('AssignofficerList') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Admin.addArea') }}">{{ __('Add-Area') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Admin.areaList') }}">{{ __('areaList') }}</a></li>
                                </ul>
                                </li>
                            </ul>
                        </div>

                        
                        <li class="nav-item">
                             <a class="nav-link" href="{{ route('Admin.verify-officer-account') }}">{{ __('Verifyofficeracount') }}</a>
                        </li>
                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
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
