<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Management - Login</title>
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

        .login-card{
            width:420px;
            background:#fff;
            border-radius:15px;
            padding:35px;
            box-shadow:0 15px 35px rgba(0,0,0,.2);
        }

        .login-title{
            text-align:center;
            font-weight:700;
            color:#4f46e5;
            margin-bottom:25px;
        }

        .form-control{
            height:48px;
            border-radius:10px;
        }

        .btn-login{
            background:#4f46e5;
            color:#fff;
            height:48px;
            border-radius:10px;
            font-weight:600;
        }

        .btn-login:hover{
            background:#4338ca;
            color:#fff;
        }

        a{
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="login-card">

    <h2 class="login-title">Rental Management</h2>

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

    <form action="{{ route('login.store') }}" method="POST">
        @csrf

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

        <button class="btn btn-login w-100">
            Login
        </button>

    </form>

    <div class="text-center mt-4">
        Don't have an account?
        <a href="{{ route('register') }}">Register</a>
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