<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WEB-SYY Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #212529; color: #fff; }

        /* Sidebar */
        #sidebar {
            min-height: 100vh;
            width: 220px;
            background-color: #000;
            flex-shrink: 0;
        }
        #sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
            border-radius: 6px;
            margin: 2px 8px;
            transition: background 0.2s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: #343a40;
            color: #fff;
        }
        #sidebar .nav-link i { margin-right: 8px; }
        #sidebar .sidebar-brand {
            font-size: 1.1rem;
            font-weight: 700;
            padding: 18px 20px;
            border-bottom: 1px solid #343a40;
            color: #fff;
        }

        /* Main content */
        #main-content {
            flex: 1;
            overflow-x: hidden;
        }

        /* Navbar */
        .top-navbar {
            background-color: #000;
            border-bottom: 1px solid #343a40;
        }

        /* Cards */
        .card-dark {
            background-color: #2b3035;
            border: 1px solid #343a40;
            border-radius: 10px;
        }

        /* Tables */
        .table-dark th { background-color: #000 !important; }

        @media (max-width: 768px) {
            #sidebar { display: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex">

    {{-- ─── SIDEBAR ─────────────────────────────────────────── --}}
    <nav id="sidebar" class="d-flex flex-column py-2">
        <div class="sidebar-brand">
            <i class="bi bi-grid-fill"></i> WEB-SYY
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('food-orders.index') }}"
                   class="nav-link {{ request()->routeIs('food-orders.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-fill"></i> Food Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.show') }}"
                   class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> Profile
                </a>
            </li>
        </ul>

        {{-- Logout at bottom --}}
        <div class="mt-auto p-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    {{-- ─── MAIN AREA ───────────────────────────────────────── --}}
    <div id="main-content" class="d-flex flex-column">

        {{-- Top Navbar --}}
        <nav class="top-navbar navbar px-4 py-2">
            <span class="navbar-text text-white fw-semibold">
                <i class="bi bi-person-fill me-1"></i>
                {{ auth()->user()->name }}
            </span>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('profile.show') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-person-circle"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

        {{-- Page Content --}}
        <div class="container-fluid py-4 px-4">
            @yield('content')
        </div>

    </div>
</div>

{{-- ─── TOAST NOTIFICATIONS ─────────────────────────────────── --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    @if(session('success'))
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div id="validationToast" class="toast align-items-center text-bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        ['successToast', 'errorToast', 'validationToast'].forEach(id => {
            const el = document.getElementById(id);
            if (el) new bootstrap.Toast(el, { delay: 4000 }).show();
        });
    });
</script>
@stack('scripts')
</body>
</html>
