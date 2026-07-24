<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

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

    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('images/otoms.png') }}" rel="icon">

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

    <style>
        /* ==============================
           CSS CUSTOM PROPERTIES
        ============================== */
        :root {
            --sidebar-width: 260px;
            --navbar-height: 56px;
            --sidebar-bg: #198754;
            --sidebar-hover: rgba(255,255,255,0.10);
            --sidebar-active: rgba(255,255,255,0.20);
            --transition: all 0.3s ease;
        }

        /* ==============================
           RESET & BASE
        ============================== */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }

        /* ==============================
           SPINNER
        ============================== */
        #spinner {
            z-index: 9999;
        }

        /* ==============================
           LAYOUT WRAPPER
        ============================== */
        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* ==============================
           SIDEBAR OVERLAY (mobile)
        ============================== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ==============================
           SIDEBAR
        ============================== */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-header {
            padding: 1.25rem 1rem 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-brand img {
            max-width: 140px;
            height: auto;
        }

        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 1.4rem;
            cursor: pointer;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            transition: var(--transition);
        }

        .sidebar-close-btn:hover {
            color: #fff;
            background: var(--sidebar-hover);
        }

        .sidebar-role {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .sidebar-role .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.75em;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0.5rem 0;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.25rem;
            color: rgba(255,255,255,0.75) !important;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0;
            transition: var(--transition);
            white-space: nowrap;
            border-left: 3px solid transparent;
            text-decoration: none;
        }

        .sidebar-nav .nav-link:hover {
            color: #fff !important;
            background: var(--sidebar-hover);
            border-left-color: rgba(255,255,255,0.4);
        }

        .sidebar-nav .nav-link.active {
            color: #fff !important;
            background: var(--sidebar-active);
            border-left-color: #fff;
        }

        .sidebar-nav .nav-link i {
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        /* ==============================
           MAIN CONTENT AREA
        ============================== */
        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* ==============================
           TOP NAVBAR
        ============================== */
        .top-navbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #198754 !important;
            height: var(--navbar-height);
            display: flex;
            align-items: center;
            padding: 0 1rem;
            gap: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .sidebar-toggle-btn {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 0.3rem 0.5rem;
            border-radius: 6px;
            transition: var(--transition);
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(255,255,255,0.15);
        }

        .navbar-title {
            flex: 1;
            text-align: center;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0 0.5rem;
        }

        .user-dropdown .nav-link {
            color: #fff !important;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
        }

        .user-dropdown .dropdown-menu {
            background: #157347;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
            min-width: 140px;
            margin-top: 0.3rem;
        }

        .user-dropdown .dropdown-item {
            color: rgba(255,255,255,0.85) !important;
            font-size: 0.875rem;
            padding: 0.55rem 1rem;
            transition: var(--transition);
        }

        .user-dropdown .dropdown-item:hover {
            background: rgba(255,255,255,0.12);
            color: #fff !important;
        }

        /* ==============================
           PAGE CONTENT
        ============================== */
        .page-content {
            flex: 1;
            padding: 1.5rem;
        }

        /* ==============================
           RESPONSIVE BREAKPOINTS
        ============================== */

        /* Large Desktop (1200px+) */
        @media (min-width: 1200px) {
            .navbar-title {
                font-size: 1.15rem;
            }
        }

        /* Tablet & Small Desktop (768px - 991px) */
        @media (max-width: 991px) {
            :root {
                --sidebar-width: 240px;
            }

            .navbar-title {
                font-size: 0.9rem;
            }
        }

        /* Mobile & Tablet below 992px — sidebar becomes off-canvas */
        @media (max-width: 991px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
                box-shadow: none;
            }

            .sidebar.open {
                left: 0;
                box-shadow: 4px 0 20px rgba(0,0,0,0.3);
            }

            .sidebar-close-btn {
                display: block;
            }

            .main-wrapper {
                margin-left: 0 !important;
            }

            .sidebar-toggle-btn {
                display: flex;
            }
        }

        /* Mobile below 576px */
        @media (max-width: 575px) {
            :root {
                --sidebar-width: 85vw;
            }

            .navbar-title {
                font-size: 0.78rem;
                letter-spacing: 0;
            }

            .page-content {
                padding: 1rem 0.75rem;
            }
        }

        /* Very small screens */
        @media (max-width: 380px) {
            .navbar-title {
                font-size: 0.68rem;
            }
        }

        /* ==============================
           SCROLLBAR STYLING (sidebar)
        ============================== */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.15);
            border-radius: 2px;
        }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Sidebar Overlay (mobile backdrop) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="layout-wrapper">

        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar" id="sidebar">

            <div class="sidebar-header">
                <a href="{{ route('Admin.index') }}" class="sidebar-brand">
                    <img src="{{ asset('images/otoms.png') }}" alt="OTOMS Logo">
                </a>
                <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close sidebar">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <div class="sidebar-role">
                <span class="badge bg-primary">
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        Admin
                    @elseif(Auth::check() && Auth::user()->role == 'officer')
                        Officer
                    @else
                        Driver
                    @endif
                </span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard', 'home') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt"></i> Dashboard
                </a>

                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('Admin.verifyOfficerAccount') }}" class="nav-link {{ request()->routeIs('Admin.verifyOfficerAccount') ? 'active' : '' }}">
                        <i class="fa fa-check"></i> Verify Officer
                    </a>
                    <a href="{{ route('Admin.offense-management') }}" class="nav-link {{ request()->routeIs('Admin.offense-management') ? 'active' : '' }}">
                        <i class="fa fa-list"></i> Offense Management
                    </a>
                    <a href="{{ route('Admin.addThana') }}" class="nav-link {{ request()->routeIs('Admin.addThana') ? 'active' : '' }}">
                        <i class="fa fa-plus"></i> Add Thana
                    </a>
                    <a href="{{ route('Admin.thanaList') }}" class="nav-link {{ request()->routeIs('Admin.thanaList') ? 'active' : '' }}">
                        <i class="fa fa-list"></i> Thana List
                    </a>
                    <a href="{{ route('Admin.assignOfficer') }}" class="nav-link {{ request()->routeIs('Admin.assignOfficer') ? 'active' : '' }}">
                        <i class="fa fa-user"></i> Assign Officer
                    </a>
                    <a href="{{ route('Admin.assignOfficerList') }}" class="nav-link {{ request()->routeIs('Admin.assignOfficerList') ? 'active' : '' }}">
                        <i class="fa fa-list"></i> Assigned Officer
                    </a>
                    <a href="{{ route('Admin.addArea') }}" class="nav-link {{ request()->routeIs('Admin.addArea') ? 'active' : '' }}">
                        <i class="fa fa-plus"></i> Add Area
                    </a>
                    <a href="{{ route('Admin.areaList') }}" class="nav-link {{ request()->routeIs('Admin.areaList') ? 'active' : '' }}">
                        <i class="fa fa-list"></i> Area List
                    </a>
                @endif

                @if(Auth::check() && Auth::user()->area_lead != null && Auth::user()->role == 'officer')
                    <a href="{{ route('Officer.addOffense') }}" class="nav-link {{ request()->routeIs('Officer.addOffense') ? 'active' : '' }}">
                        <i class="fa fa-plus"></i> Add Offense
                    </a>
                    <a href="{{ route('Officer.offenseList') }}" class="nav-link {{ request()->routeIs('Officer.offenseList') ? 'active' : '' }}">
                        <i class="fa fa-list"></i> Offense List
                    </a>
                @elseif(Auth::check() && Auth::user()->role == 'user')
                    <a href="{{ route('User.index') }}" class="nav-link {{ request()->routeIs('User.index') ? 'active' : '' }}">
                        <i class="fa fa-exclamation-triangle"></i> My Offense
                    </a>
                @endif

                <a href="{{ route('User.profileShow') }}" class="nav-link {{ request()->routeIs('User.profileShow') ? 'active' : '' }}">
                    <i class="fa fa-user"></i> My Profile
                </a>
            </nav>

        </aside>
        <!-- ===== SIDEBAR END ===== -->

        <!-- ===== MAIN WRAPPER ===== -->
        <div class="main-wrapper" id="mainWrapper">

            <!-- Top Navbar -->
            <nav class="top-navbar">
                <!-- Hamburger (mobile only) -->
                <button class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Toggle sidebar">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Title -->
                <span class="navbar-title">Online Traffic Offense Management System</span>

                <!-- User Dropdown -->
                <div class="nav-item dropdown user-dropdown" style="position:relative;">
                    <a href="#" class="nav-link" id="userDropdownToggle" aria-expanded="false">
                        <i class="fa fa-user-circle fa-lg"></i>
                        <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        <i class="fa fa-caret-down ms-1" style="font-size:0.75rem;"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" id="userDropdownMenu" style="display:none; position:absolute; right:0; top:100%; margin-top:0.3rem;">
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out-alt me-2"></i>Log Out
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>
            <!-- Top Navbar End -->

            <!-- Page Content -->
            <main class="page-content">
                @yield('content')
            </main>
            <!-- Page Content End -->

        </div>
        <!-- ===== MAIN WRAPPER END ===== -->

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // ==============================
        // USER DROPDOWN (manual — avoids Bootstrap CSS conflict)
        // ==============================
        const dropToggle = document.getElementById('userDropdownToggle');
        const dropMenu   = document.getElementById('userDropdownMenu');

        dropToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = dropMenu.style.display === 'block';
            dropMenu.style.display = isOpen ? 'none' : 'block';
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropToggle.contains(e.target) && !dropMenu.contains(e.target)) {
                dropMenu.style.display = 'none';
            }
        });

        // ==============================
        // SIDEBAR TOGGLE (Mobile)
        // ==============================
        const sidebar   = document.getElementById('sidebar');
        const overlay   = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const closeBtn  = document.getElementById('sidebarCloseBtn');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        toggleBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Close sidebar when a nav link is clicked on mobile
        sidebar.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) closeSidebar();
            });
        });

        // Restore sidebar state on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // ==============================
        // SPINNER HIDE ON LOAD
        // ==============================
        window.addEventListener('load', () => {
            const spinner = document.getElementById('spinner');
            if (spinner) spinner.style.display = 'none';
        });
    </script>

    @stack('scripts')
</body>

</html>
