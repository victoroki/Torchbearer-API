<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Torchbearer') }} - Admin Panel</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('torchbearer-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('torchbearer-logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

       <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
    
    <!-- Bootstrap Timepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
    
    <!-- Custom Styles Section -->
    @yield('styles')
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #B8860B;
            --primary-dark: #996515;
            --primary-darker: #7A5210;
            --cream-bg: #FEFCF6;
            --warm-gray: #D4C4A8;
            --light-beige: #F5F0E8;
            --primary-gradient: linear-gradient(135deg, #B8860B 0%, #996515 100%);
            --secondary-gradient: linear-gradient(135deg, #FEFCF6 0%, #F5F0E8 100%);
            --warm-gradient: linear-gradient(135deg, #F5F0E8 0%, #E8DCC6 100%);
            --sidebar-bg: #7A5210;
            --sidebar-hover: #8B5A14;
            --text-muted: #9CA3AF;
            --text-dark: #374151;
            --border-color: #E5E7EB;
            --shadow-light: 0 2px 10px rgba(122, 82, 16, 0.06);
            --shadow-medium: 0 4px 20px rgba(122, 82, 16, 0.08);
            --shadow-heavy: 0 8px 30px rgba(122, 82, 16, 0.12);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--secondary-gradient);
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .main-sidebar {
            background: var(--sidebar-bg);
            box-shadow: var(--shadow-medium);
        }

        .sidebar {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--text-muted) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--text-muted);
            border-radius: 2px;
        }

        /* Brand Logo */
        .brand-link {
            background: var(--primary-gradient);
            border-bottom: 1px solid var(--primary-darker);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            background: linear-gradient(135deg, #B45309 0%, #D97706 100%);
        }

        .brand-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .brand-text {
            color: white !important;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: -0.02em;
        }

        /* Navigation Menu */
        .nav-sidebar .nav-item .nav-link {
            color: #E5E7EB;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .nav-sidebar .nav-item .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(4px);
            box-shadow: var(--shadow-light);
        }

        .nav-sidebar .nav-item .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow-medium);
        }

        .nav-sidebar .nav-item .nav-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: white;
            border-radius: 2px;
        }

        .nav-icon {
            margin-right: 12px !important;
            width: 18px;
            text-align: center;
        }

        .nav-sidebar .nav-item .nav-link p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Main Header */
        .main-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-light);
        }

        .navbar-light .navbar-nav .nav-link {
            color: var(--text-dark);
            font-weight: 500;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: var(--primary-color);
        }

        /* User Panel */
        .user-panel {
            padding: 20px 20px 10px 20px;
            border-bottom: 1px solid var(--primary-darker);
            margin-bottom: 10px;
        }

        .user-panel .image img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
        }

        .user-panel .info a {
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .user-panel .status {
            color: #D1D5DB;
            font-size: 0.85rem;
            margin-top: 2px;
        }

        /* Content Wrapper */
        .content-wrapper {
            background: transparent;
            min-height: calc(100vh - 57px);
        }

        .content-header {
            background: white;
            margin: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            padding: 20px 30px;
        }

        .content-header h1 {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
        }

        .breadcrumb {
            background: transparent;
            margin: 0;
            padding: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        /* Content */
        .content {
            padding: 0 20px 20px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--warm-gradient);
            border-bottom: 1px solid var(--border-color);
            padding: 20px 25px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .card-body {
            padding: 25px;
            background: white;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 12px rgba(184, 134, 11, 0.25);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #996515 0%, #B8860B 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(184, 134, 11, 0.35);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            border: none;
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            border: none;
            color: white;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            padding: 8px 0;
            margin-top: 8px;
            min-width: 200px;
        }

        .dropdown-item {
            color: var(--text-dark);
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            background: none;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background: var(--cream-bg);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .dropdown-item.text-danger {
            color: #DC2626;
        }

        .dropdown-item.text-danger:hover {
            background: #FEF2F2;
            color: #B91C1C;
        }

        .dropdown-divider {
            border-top: 1px solid var(--border-color);
            margin: 8px 0;
        }

        /* Tables */
        .table {
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .table thead th {
            border: none;
            background: var(--warm-gradient);
            color: var(--text-dark);
            font-weight: 600;
            padding: 15px 20px;
        }

        .table tbody td {
            border-top: 1px solid var(--border-color);
            padding: 15px 20px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--cream-bg);
        }

        /* Forms */
        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: white;
            color: var(--text-dark);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
        }

        .alert-success {
            background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
            color: #065F46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #991B1B;
        }

        /* Footer */
        .main-footer {
            background: white;
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 15px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .content-header {
                margin: 10px;
                padding: 15px 20px;
            }

            .content {
                padding: 0 10px 10px;
            }

            .card-body {
                padding: 20px;
            }
        }

        /* Loading Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content>* {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Custom Scrollbar for main content */
        .content-wrapper {
            scrollbar-width: thin;
            scrollbar-color: var(--warm-gray) var(--cream-bg);
        }

        .content-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .content-wrapper::-webkit-scrollbar-track {
            background: var(--cream-bg);
        }

        .content-wrapper::-webkit-scrollbar-thumb {
            background: var(--warm-gray);
            border-radius: 4px;
        }

        .content-wrapper::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="fas fa-home me-1"></i>
                        Home
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>
                        {{ __('Login') }}
                    </a>
                </li>
                @endif
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>
                        {{ __('Register') }}
                    </a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        {{ Auth::user()->username ?? Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user-cog me-2"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <div class="brand-image">
                    <i class="fas fa-fire"></i>
                </div>
                <span class="brand-text">{{ config('app.name', 'TorchBearer') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                @auth
                <!-- User Panel -->
                <div class="user-panel d-flex">
                    <div class="image">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username ?? Auth::user()->name) }}&background=D97706&color=fff&size=128" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->username ?? Auth::user()->name }}</a>
                        <div class="status">
                            <i class="fas fa-circle text-success" style="font-size: 8px;"></i>
                            Online
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') || Request::is('home') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Include Menu Items -->
                        @include('layouts.menu')
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('content_header_title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('content_header')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Flash Messages -->
                    @if(session('flash_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('flash_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer text-center">
            <div class="float-right d-none d-sm-block">
                <strong>Version</strong> 1.0.0
            </div>
            <strong>Copyright &copy; {{ date('Y') }} {{ config('app.name', 'TorchBearer') }}.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    
    <!-- Bootstrap Timepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Ensure dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap dropdowns
            var dropdowns = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            dropdowns.map(function(dropdown) {
                return new bootstrap.Dropdown(dropdown);
            });
        });
    </script>
    @stack('page_scripts')
    @yield('scripts')
</body>

</html>