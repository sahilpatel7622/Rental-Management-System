@extends('layouts.admin')

@section('title','Dashboard')
@section('page','Dashboard')

@section('content')

<style>
.dashboard-card{
    transition:.3s;
    cursor:pointer;
}

.dashboard-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 30px rgba(0,0,0,.15)!important;
}
</style>

<div class="card border-0 shadow-sm rounded-4 mt-2">
    <div class="card-body">

        <h4 class="fw-bold mb-3">
            Welcome, {{ session('user_name') }}
        </h4>

        <p class="text-muted mb-0">
            Welcome to the <strong>Rental Management System</strong> Admin Dashboard.
            You can manage users, properties, bookings and payments from here.
        </p>

    </div>
</div>

<br>

<div class="row g-4">

    {{-- Users --}}
    <div class="col-lg-3 col-md-6">
        <div class="card dashboard-card border-0 shadow-sm rounded-4 bg-primary text-white"
             onclick="window.location='{{ route('admin.users') }}'">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="mb-2">Total Users</h6>
                    <h2 class="fw-bold">{{ $totalUsers }}</h2>
                </div>

                <div class="fs-1">
                    <i class="fa-solid fa-users"></i>
                </div>

            </div>

        </div>
    </div>

    {{-- Properties --}}
    <div class="col-lg-3 col-md-6">
        <div class="card dashboard-card border-0 shadow-sm rounded-4 bg-success text-white"
             onclick="window.location='{{ route('admin.property') }}'">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="mb-2">Total Properties</h6>
                    <h2 class="fw-bold">{{ $totalProperties }}</h2>
                </div>

                <div class="fs-1">
                    <i class="fa-solid fa-building"></i>
                </div>

            </div>

        </div>
    </div>

    {{-- Bookings --}}
    <div class="col-lg-3 col-md-6">
        <div class="card dashboard-card border-0 shadow-sm rounded-4 bg-warning text-white"
             onclick="window.location='{{ route('admin.bookings') }}'">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="mb-2">Total Bookings</h6>
                    <h2 class="fw-bold">{{ $totalBookings }}</h2>
                </div>

                <div class="fs-1">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

            </div>

        </div>
    </div>

    {{-- Payments --}}
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('admin.payments') }}" class="text-decoration-none">
            <div class="card dashboard-card border-0 shadow-sm rounded-4 bg-danger text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2">Total Amount</h6>
                        <h2 class="fw-bold">
                            ₹{{ number_format($totalAmount, 2) }}
                        </h2>
                    </div>

                    <div class="fs-1">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>

@endsection