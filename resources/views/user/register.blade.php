<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Management - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#4f46e5,#7c3aed);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial,sans-serif;
        }

        .register-card{
            width:450px;
            background:#fff;
            border-radius:15px;
            padding:35px;
            box-shadow:0 15px 35px rgba(0,0,0,.2);
        }

        .register-title{
            text-align:center;
            color:#4f46e5;
            font-weight:700;
            margin-bottom:25px;
        }

        .form-control{
            height:48px;
            border-radius:10px;
        }

        .btn-register{
            background:#4f46e5;
            color:#fff;
            height:48px;
            border-radius:10px;
            font-weight:600;
        }

        .btn-register:hover{
            background:#4338ca;
            color:#fff;
        }

        a{
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="register-card">

    <h2 class="register-title">Create Account</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter Full Name">

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Enter Email">

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text"
                   name="phone"
                   value="{{ old('phone') }}"
                   class="form-control @error('phone') is-invalid @enderror"
                   placeholder="Enter Phone Number">

            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label>Password</label>
            <div class="input-group">
                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Enter Password">
                <button class="btn btn-outline-secondary toggle-password" type="button" style="border-radius: 0 10px 10px 0; border: 1px solid #dee2e6;">
                    <i class="fa-solid fa-eye"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-register w-100">
           Register
        </button>

    </form>

    <div class="text-center mt-4">
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </div>

</div>

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

</body>
</html>