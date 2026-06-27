@forelse($rooms as $room)
    <div class="col-lg-4 col-md-6" style="position: relative; bottom: 40px">
        <div class="card room-card h-100">
            @if($room->image)
                <img src="{{ asset('property/'.$room->image) }}" class="room-img">
            @else
                <div class="room-img d-flex justify-content-center align-items-center text-muted">
                    No Image
                </div>
            @endif
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold mb-0">{{ $room->title }}</h5>
                    <span class="badge-room">{{ ucfirst($room->status) }}</span>
                </div>
                <p class="text-muted mb-2">
                    <i class="fa-solid fa-location-dot text-danger"></i>
                    {{ $room->location }}
                </p>
                <h4 class="price mb-3">
                    ₹{{ number_format($room->rent_price,2) }}/Month
                </h4>
                <p class="text-muted">
                    {{ \Illuminate\Support\Str::limit($room->description,100) }}
                </p>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('user.room.details',$room->slug) }}"
                class="btn btn-primary w-100">
                    <i class="fa-solid fa-eye"></i>
                    View Details
                </a>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-warning text-center">
            No rooms found.
        </div>
    </div>
@endforelse
