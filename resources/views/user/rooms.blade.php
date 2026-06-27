@extends('layouts.user')

@section('title','Rooms')

@section('content')

<style>
    .filter-card{
        border:0;
        border-radius:18px;
        box-shadow:0 8px 25px rgba(0,0,0,.08);
    }

    .room-card{
        border:0;
        border-radius:18px;
        overflow:hidden;
        box-shadow:0 8px 25px rgba(0,0,0,.08);
        transition:.3s;
    }

    .room-card:hover{
        transform:translateY(-6px);
    }

    .room-img{
        width:100%;
        height:220px;
        object-fit:cover;
        background:#f1f5f9;
    }

    .price{
        color:#2563eb;
        font-weight:700;
        font-size:22px;
    }

    .badge-room{
        background:#198754;
        color:#fff;
        border-radius:20px;
        padding:6px 12px;
        font-size:12px;
    }

    .form-select{
        height:45px;
        border-radius:10px;
    }

    .btn{
        border-radius:10px;
    }
</style>

<h2 class="fw-bold mb-2" style="position: relative; bottom: 23px">
    Available Rooms
</h2>

<div class="card filter-card mb-4" style="position: relative; bottom: 20px">

    <div class="card-body">

        <form action="{{ route('user.rooms') }}" method="GET" id="filter-form">

            <div class="row">

                <div class="col-md-4">

                    <select name="location" id="location-select" class="form-select">

                        <option value="">All Locations</option>

                        @foreach($locations as $location)

                            <option value="{{ $location->location }}"
                                {{ request('location') == $location->location ? 'selected' : '' }}>

                                {{ $location->location }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3">

                    {{-- <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                        Filter
                    </button> --}}

                    <button type="button" id="reset-btn" class="btn btn-secondary">
                        Reset
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="row g-4" id="rooms-container">

    @include('user.rooms_list')

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const locationSelect = document.getElementById('location-select');
    const roomsContainer = document.getElementById('rooms-container');
    const resetBtn = document.getElementById('reset-btn');

    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        fetchRooms();
    });

    locationSelect.addEventListener('change', function() {
        fetchRooms();
    });

    resetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        locationSelect.value = '';
        fetchRooms();
    });

    function fetchRooms() {
        const location = locationSelect.value;
        const url = "{{ route('user.rooms') }}?location=" + encodeURIComponent(location);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            roomsContainer.innerHTML = html;
        })
        .catch(error => console.error('Error fetching rooms:', error));
    }
});
</script>
@endsection