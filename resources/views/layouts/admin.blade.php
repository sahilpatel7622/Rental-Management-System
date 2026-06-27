<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#eef2f7;
            font-family:'Segoe UI', Arial, sans-serif;
        }

        .sidebar{
            width:250px;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            background:linear-gradient(180deg,#111827,#1f2937);
            color:#fff;
            box-shadow:4px 0 20px rgba(0,0,0,.18);
            position:fixed;
            display:flex;
            flex-direction:column;
        }

        .sidebar > .logo{
            padding:24px 20px;
            text-align:center;
            font-size:30px;
            color:#fff;
            display:block;
            font-weight:800;
            letter-spacing:.5px;
            border-bottom:1px solid rgba(255,255,255,.12);
            margin-bottom:0;
            border-radius:0;
            justify-content:center;
        }

        .logo span{
            color:#60a5fa;
        }

        .sidebar-menu{
            padding:18px 14px;
            display:flex;
            flex-direction:column;
            flex:1;
        }

        .sidebar a{
            display:flex;
            align-items:center;
            gap:12px;
            color:#d1d5db;
            padding:14px 16px;
            margin-bottom:8px;
            border-radius:12px;
            text-decoration:none;
            transition:.3s;
            font-size:15px;
            font-weight:500;
        }

        .sidebar a i{
            width:22px;
            text-align:center;
            font-size:17px;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,.12);
            color:#fff;
            transform:translateX(4px);
        }

        .sidebar a.active{
            background:#2563eb;
            color:#fff;
            box-shadow:0 8px 18px rgba(37,99,235,.35);
        }

        .content{
            margin-left:260px;
            min-height:100vh;
        }

        .topbar{
            height:70px;
            background:#fff;
            box-shadow:0 4px 18px rgba(0,0,0,.08);
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 30px;
            position:sticky;
            top:0;
            z-index:10;
        }

        .topbar h5{
            font-weight:700;
            color:#111827;
        }

        .admin-profile{
            display:flex;
            align-items:center;
            gap:12px;
            background:#f3f4f6;
            padding:8px 14px;
            border-radius:50px;
            font-weight:600;
            color:#374151;
        }

        .admin-profile i{
            background:#2563eb;
            color:#fff;
            width:34px;
            height:34px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:50%;
        }

        .main-content{
            padding:30px;
        }

        .colored-toast{
            /* border-radius:12px !important; */
            /* box-shadow:0 8px 25px rgba(0,0,0,.15) !important; */
            padding:10px 15px !important;
            font-size:18px;
            font-weight:600;
        }

        .swal2-success-ring{
            border-color:#d4edda !important;
        }
        .logout-link{
            margin-top:auto;
        }
    </style>
</head>
<body>

<div class="sidebar">

    <a href="{{ route('admin.dashboard') }}" class="logo text-decoration-none">
        Rental <span>Admin</span>
    </a>

    <div class="sidebar-menu">

        <a href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.users') }}"
            class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            Users
        </a>

        <a href="{{ route('admin.property') }}"
            class="{{ request()->routeIs('admin.property') ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i>
            Property
        </a>

        <a href="{{ route('admin.bookings') }}"
            class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i>
            Bookings
        </a>

        <a href="{{ route('admin.payments') }}"
            class="{{ request()->routeIs('admin.payments') ? 'active' : '' }}">
            <i class="fa-solid fa-credit-card"></i>
            Payments
        </a>

        <a href="{{ route('logout') }}" class="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>

    </div>

</div>

<div class="content">

    <div class="topbar">

        <h5 class="mb-0">@yield('page')</h5>

        <div class="admin-profile">
            <i class="fa-solid fa-user"></i>
            {{ session('user_name') }}
        </div>

    </div>

    <div class="main-content">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success') || session('info') || session('error'))
@php
    $type = session('success') ? 'success' : (session('info') ? 'info' : 'error');
    $message = session('success') ?? (session('info') ?? session('error'));
    $color = session('success') ? '#4CAF50' : (session('info') ? '#2196F3' : '#F44336');
@endphp
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#fff',
    color: '#333',
    iconColor: '{{ $color }}',
    customClass: {
        popup: 'colored-toast'
    },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

Toast.fire({
    icon: '{{ $type }}',
    title: '{{ $message }}'
});
</script>
@endif


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
@stack('scripts')

</body>
</html> 