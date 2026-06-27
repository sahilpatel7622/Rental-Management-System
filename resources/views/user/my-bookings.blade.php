@extends('layouts.user')

@section('title','My Bookings')

@section('content')

<style>
    body{
        background:#f5f7fb;
    }

    .booking-hero{
        background:linear-gradient(135deg,#2563eb,#3b82f6);
        color:#fff;
        padding:45px 0;
        margin-bottom:35px;
    }

    .booking-card{
        border:none;
        border-radius:18px;
        overflow:hidden;
        transition:.3s;
    }

    .booking-card:hover{
        transform:translateY(-6px);
        box-shadow:0 18px 35px rgba(0,0,0,.12);
    }

    .booking-card .card-body{
        padding:22px;
    }

    .booking-card p{
        margin-bottom:10px;
    }

    .booking-card hr{
        margin:15px 0;
    }

    .status{
        padding:4px 10px;
        border-radius:30px;
        color:#fff;
        font-size:13px;
    }

    .success{
        background:#16a34a;
    }

    .pending{
        background:#f59e0b;
    }

    .failed{
        background:#dc2626;
    }
</style>

<div class="booking-hero">
    <div class="container">
        <h2 class="fw-bold">My Bookings</h2>
        <p class="mb-0">View all your booked properties.</p>
    </div>
</div>

<div class="container">

    <div class="row g-4">

        @forelse($bookings as $booking)

        <div class="col-lg-4 col-md-6">

            <div class="card booking-card shadow-sm h-100">

                <div class="card-body">

                    <h4 class="fw-bold">
                        {{ $booking->property->title }}
                    </h4>

                    <p class="text-muted">
                        <i class="fa-solid fa-location-dot text-danger"></i>
                        {{ $booking->property->location }}
                    </p>

                    <hr>

                    <p><strong>User :</strong> {{ $booking->user->name }}</p>

                    <p><strong>Check In :</strong>
                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                    </p>

                    <p><strong>Check Out :</strong>
                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                    </p>

                    <p><strong>Total Days :</strong>
                        {{ $booking->total_days }}
                    </p>

                    <p><strong>Amount :</strong>
                        ₹{{ number_format($booking->total_amount,2) }}
                    </p>

                    <p><strong>Payment :</strong>
                        {{ $booking->payment->payment_method ?? '-' }}
                    </p>

                    <p>
                        <strong>Status :</strong>

                        @if(optional($booking->payment)->payment_status=='success')
                            <span class="status success">Success</span>
                        @elseif(optional($booking->payment)->payment_status=='pending')
                            <span class="status pending">Pending</span>
                        @else
                            <span class="status failed">Failed</span>
                        @endif
                    </p>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">
            <div class="alert alert-info text-center">
                No Booking Found.
            </div>
        </div>

        @endforelse

    </div>

</div>

@endsection