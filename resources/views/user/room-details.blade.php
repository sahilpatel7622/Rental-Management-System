@extends('layouts.user')

@section('title',$room->title)

@section('content')

<style>
    .room-box{
        border:0;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 8px 25px rgba(0,0,0,.08);
    }

    .room-image{
        width:100%;
        height:450px;
        object-fit:cover;
        background:#f5f5f5;
    }

    .price{
        color:#2563eb;
        font-size:32px;
        font-weight:700;
    }

    .related-card{
        border:0;
        border-radius:16px;
        overflow:hidden;
        box-shadow:0 5px 15px rgba(0,0,0,.08);
    }

    .related-card img{
        width:100%;
        height:180px;
        object-fit:cover;
    }
</style>

<div class="card room-box">
    <div class="row g-0">
        <div class="col-md-6">
            @if($room->image)
                <img src="{{ asset('property/'.$room->image) }}"
                     class="room-image">
            @else
                <div class="room-image d-flex justify-content-center align-items-center">
                    No Image
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="card-body p-5">
                <span class="badge bg-success mb-3">
                    {{ ucfirst($room->status) }}
                </span>
                <h2 class="fw-bold">
                    {{ $room->title }}
                </h2>
                <p class="text-muted mt-3">
                    <i class="fa-solid fa-location-dot text-danger"></i>
                    {{ $room->location }}
                </p>
                <h3 class="price">
                    ₹{{ number_format($room->rent_price,2) }}
                    <small class="fs-5 text-muted">/Month</small>
                </h3>
                <hr>
                <h5>Description</h5>
                <p class="text-muted">
                    {{ $room->description }}
                </p><br>
                <a href="{{ route('user.booking.summary', $room->slug) }}"
                class="btn btn-primary w-100">
                    Book Now
                </a>
            </div>
        </div>
    </div>
</div>

@endsection