@extends('layouts.user')

@section('title','Booking Summary')

@section('content')

<style>
    .summary-card{
        border:0;
        border-radius:20px;
        box-shadow:0 8px 25px rgba(0,0,0,.08);
        overflow:hidden;
    }

    .room-img{
        width:100%;
        height:220px;
        object-fit:cover;
        border-radius:15px;
    }

    .price{
        color:#2563eb;
        font-size:26px;
        font-weight:800;
    }

    .form-control,
    .form-select{
        border-radius:10px;
        height:45px;
    }

    .total-box{
        background:#f8fafc;
        border-radius:16px;
        padding:18px;
    }
    #bookingLoader{
        display:none;
        position:absolute;
        inset:0;
        background:rgba(255,255,255,.7);
        justify-content:center;
        align-items:center;
        z-index:999;
    }
</style>

<h2 class="fw-bold mb-4">Booking Summary</h2>

<div class="card summary-card p-4 position-relative">
    <div id="bookingLoader">
        <div class="spinner-border text-primary"></div>
    </div>
    <div class="row g-4 align-items-stretch">
        {{-- Room Details --}}
        <div class="col-md-5 border-end">
            <h4 class="fw-bold mb-3">Room Details</h4>
            <hr>
            @if($room->image)
                <img src="{{ asset('property/'.$room->image) }}" class="room-img mb-3">
            @else
                <div class="room-img d-flex align-items-center justify-content-center text-muted mb-3">
                    No Image
                </div>
            @endif
            <h3 class="fw-bold">{{ $room->title }}</h3>
            <p class="text-muted mb-2">
                <i class="fa-solid fa-location-dot text-danger"></i>
                {{ $room->location }}
            </p>
            <h2 class="price mb-3">
                ₹{{ number_format($room->rent_price,2) }}
                <small class="fs-5 text-muted">/ Month</small>
            </h2>
        </div>

        {{-- User Details --}}
        <div class="col-md-7">
            <h4 class="fw-bold mb-3">User Details</h4>
            <hr>
            <div class="row mb-3"> 
                <div class="col-md-3">
                    <strong>Name:</strong> {{ session('user_name') }}
                </div>
                <div class="col-md-5">
                    <strong>Email:</strong> {{ session('user_email') }}
                </div>
                <div class="col-md-4">
                    <strong>Phone:</strong> {{ session('user_phone') }}
                </div> 
            </div>

            <form id="bookingForm" action="{{ route('booking.store', $room->slug) }}" method="POST">
                @csrf
                <input type="hidden" id="rent_price" value="{{ $room->rent_price }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Check In</label>
                      <input type="date" name="check_in" id="check_in"
                            value="{{ old('check_in') }}"
                            class="form-control @error('check_in') is-invalid @enderror">
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Check Out</label>
                        <input type="date" name="check_out" id="check_out"
                            value="{{ old('check_out') }}"
                            class="form-control @error('check_out') is-invalid @enderror">
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method"
                            class="form-select @error('payment_method') is-invalid @enderror">
                            <option value="">Select Payment Method</option>
                            <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="UPI" {{ old('payment_method') == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Card" {{ old('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                        </select>

                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="total-box mb-3">
                    <p class="mb-1">
                        <strong>Total Days:</strong>
                        <span id="total_days">0</span>
                    </p>

                    <p class="mb-0">
                        <strong>Total Amount:</strong>
                        ₹<span id="total_amount">0</span>
                    </p>
                </div>

                <button class="btn btn-primary w-100">
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let today = new Date().toISOString().split('T')[0];
    let checkInInput = document.getElementById('check_in');
    let checkOutInput = document.getElementById('check_out');
    checkInInput.min = today;
    function addOneDay(dateValue) {
        let date = new Date(dateValue);
        date.setDate(date.getDate() + 1);
        return date.toISOString().split('T')[0];
    }

    function calculateAmount(){
        let checkIn = checkInInput.value;
        let checkOut = checkOutInput.value;
        let rentPrice = parseFloat(document.getElementById('rent_price').value);

        if(checkIn && checkOut){
            let start = new Date(checkIn);
            let end = new Date(checkOut);
            let diffTime = end - start;
            let days = diffTime / (1000 * 60 * 60 * 24);

            if(days > 0){
                let perDay = rentPrice / 30;
                let total = perDay * days;

                document.getElementById('total_days').innerText = days;
                document.getElementById('total_amount').innerText = total.toFixed(2);
            } else {
                checkOutInput.value = '';
                document.getElementById('total_days').innerText = 0;
                document.getElementById('total_amount').innerText = 0;
            }
        }
    }

    checkInInput.addEventListener('change', function () {
        checkOutInput.value = '';
        checkOutInput.min = addOneDay(this.value);
        calculateAmount();
    });

    checkOutInput.addEventListener('change', calculateAmount);

    document.getElementById('bookingForm').addEventListener('submit', function () {
        document.getElementById('bookingLoader').style.display = 'flex';
    });

</script>

@endsection