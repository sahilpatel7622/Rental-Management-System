<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f7fb;
            font-family:'Segoe UI', Arial, sans-serif;
            padding-top:90px;
        }

        .navbar-user{
            background:#fff;
            box-shadow:0 4px 18px rgba(0,0,0,.08);
            padding:14px 0;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            z-index:999;
        }

        .brand{
            font-size:24px;
            font-weight:800;
            color:#2563eb;
            text-decoration:none;
        }

        .nav-link{
            color:#374151;
            font-weight:600;
            transition:.3s;
        }

        .nav-link:hover,
        .nav-link.active{
            color:#2563eb;
        }

        .main-content{
            padding:20px 0 30px;
        }
    </style>
</head>
<body>

@include('layouts.loader')

<nav class="navbar navbar-expand-lg navbar-user">
    <div class="container">

        <a class="brand" href="{{ route('user.dashboard') }}">
            Room Rental
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#userMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="userMenu">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                {{-- Dashboard --}}
                @if(session()->has('user_id') && session()->get('user_role') == 'admin')

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link">
                            Dashboard
                        </a>
                    </li>

                @else

                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}"
                           class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>

                @endif

                {{-- Rooms --}}
                <li class="nav-item">
                    <a href="{{ route('user.rooms') }}"
                       class="nav-link {{ request()->routeIs('user.rooms') ? 'active' : '' }}">
                        Rooms
                    </a>
                </li>

                {{-- My Bookings --}}
                @if(session()->has('user_id') && session()->get('user_role') == 'user')
                    <li class="nav-item">
                        <a href="{{ route('user.bookings') }}"
                           class="nav-link {{ request()->routeIs('user.bookings') ? 'active' : '' }}">
                            My Bookings
                        </a>
                    </li>
                @endif

                {{-- Login / Logout --}}
                    @if(session()->has('user_id'))

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle fw-semibold"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown">

                            <i class="fa-solid fa-user-circle"></i>
                            {{ session('user_name') }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <a class="dropdown-item"
                                href="{{ route('user.profile') }}">
                                    <i class="fa-solid fa-user me-2"></i>
                                    Profile
                                </a>
                            </li>

                            <li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item text-danger"
                                href="{{ route('logout') }}">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                                    Logout
                                </a>
                            </li>

                        </ul>

                    </li>

                    @else

                    <li class="nav-item">
                        <a href="{{ route('login') }}"
                           class="btn btn-primary btn-sm me-2">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('register') }}"
                           class="btn btn-outline-primary btn-sm">
                            Register
                        </a>
                    </li>

                @endif

            </ul>

        </div>

    </div>
</nav>

<div class="container main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    title: 'Success!',
    text: '{{ session("success") }}',
    icon: 'success',
    confirmButtonColor: '#2563eb'
});
</script>

@endif
@if(session('info'))
<script>
Swal.fire({
    icon: 'info',
    title: 'Info',
    text: '{{ session("info") }}',
    confirmButtonColor: '#0d6efd'
});
</script>
@endif

</body>
</html>