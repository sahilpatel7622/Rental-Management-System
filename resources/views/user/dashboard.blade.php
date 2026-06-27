@extends('layouts.user')

@section('title','User Dashboard')

@section('content')

<style>
    .hero{
        background:linear-gradient(135deg,#2563eb,#7c3aed);
        color:#fff;
        border-radius:22px;
        padding:45px;
        box-shadow:0 12px 30px rgba(37,99,235,.25);
    }

    .dashboard-card{
        border:0;
        border-radius:18px;
        box-shadow:0 8px 25px rgba(0,0,0,.08);
    }

    .icon-box{
        width:55px;
        height:55px;
        border-radius:16px;
        background:#eff6ff;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#2563eb;
        font-size:24px;
    }
</style>

<div class="hero">
    <h1 class="fw-bold">
        Welcome, {{ session('user_name') }}
    </h1>

    <p class="mb-0 mt-2">
        Find and book your perfect rental room easily.
    </p>
</div>

<div class="row g-4 mt-4">

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Available Rooms</h6>
                   <h3 class="fw-bold mb-0">{{ $availableRooms }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">My Bookings</h6>
                    <h3 class="fw-bold mb-0">{{ $myBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Payments</h6>
                   <h3 class="fw-bold mb-0">{{ $myPayments }}</h3>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection