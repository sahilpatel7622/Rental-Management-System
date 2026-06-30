<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:linear-gradient(135deg,#4f46e5,#7c3aed);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card-box{
            width:450px;
            background:#fff;
            padding:35px;
            border-radius:15px;
            box-shadow:0 15px 35px rgba(0,0,0,.2);
        }

        .btn-send{
            background:#4f46e5;
            color:#fff;
            height:48px;
        }

        .btn-send:hover{
            background:#4338ca;
            color:#fff;
        }
    </style>
</head>
<body>

<div class="card-box">

    <h3 class="text-center mb-4">Forgot Password</h3>

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

    <form action="{{ route('forget.password.send') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Email</label>

            <input type="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Enter Email">

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-send w-100">
            Send OTP
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>

</div>

</body>
</html>