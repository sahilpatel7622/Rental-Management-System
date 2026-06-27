@extends('layouts.user')

@section('title','My Profile')

@section('content')

<div class="row g-4">

    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center p-4">

                <i class="fa-solid fa-user-circle text-primary" style="font-size:90px;"></i>

                <h3 class="fw-bold mt-3">{{ $user->name }}</h3>
                <p class="mb-1 text-muted">{{ $user->email }}</p>
                <p class="mb-3 text-muted">{{ $user->phone }}</p>

                <hr>

                <p class="mb-0">
                    <strong>Registered On:</strong>
                    {{ $user->created_at->format('d M Y') }}
                </p>

            </div>
        </div>
    </div>

    <div class="col-lg-7">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">

                <h3 class="fw-bold mb-4">Update Profile</h3>

                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name"
                            value="{{ old('name', $user->name) }}"
                            class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                            value="{{ old('email', $user->email) }}"
                            class="form-control">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                    </div>

                    <div class="mb-4">
                        <label>Mobile Number</label>
                        <input type="text" name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="form-control">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                    </div>

                    <button class="btn btn-primary">
                        Update Profile
                    </button>

                </form>

            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <h3 class="fw-bold mb-4">Change Password</h3>
                <form action="{{ route('user.password.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Current Password</label>
                        <div class="input-group">
                            <input type="password"
                                name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror">
                            <button class="btn btn-outline-secondary toggle-password" type="button" style="border-radius: 0 0.375rem 0.375rem 0; border: 1px solid #dee2e6;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>New Password</label>
                        <div class="input-group">
                            <input type="password"
                                name="new_password"
                                class="form-control @error('new_password') is-invalid @enderror">
                            <button class="btn btn-outline-secondary toggle-password" type="button" style="border-radius: 0 0.375rem 0.375rem 0; border: 1px solid #dee2e6;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label>Confirm Password</label>
                        <div class="input-group">
                            <input type="password"
                                name="new_password_confirmation"
                                class="form-control">
                            <button class="btn btn-outline-secondary toggle-password" type="button" style="border-radius: 0 0.375rem 0.375rem 0; border: 1px solid #dee2e6;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-danger">
                        Change Password
                    </button>
                </form>

            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection