<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Management - OTP Verification</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        body{
            background:linear-gradient(135deg,#4f46e5,#7c3aed);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial,sans-serif;
        }

        .otp-card{
            width:450px;
            background:#fff;
            border-radius:15px;
            padding:35px;
            box-shadow:0 15px 35px rgba(0,0,0,.2);
        }

        .otp-title{
            text-align:center;
            color:#4f46e5;
            font-weight:700;
            margin-bottom:10px;
        }

        .otp-text{
            text-align:center;
            color:#6c757d;
            margin-bottom:25px;
        }

        .form-control{
            height:48px;
            border-radius:10px;
            text-align:center;
            font-size:20px;
            letter-spacing:6px;
            font-weight:bold;
        }

        .btn-verify{
            background:#4f46e5;
            color:#fff;
            height:48px;
            border-radius:10px;
            font-weight:600;
        }

        .btn-verify:hover{
            background:#4338ca;
            color:#fff;
        }

        a{
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="otp-card">

    <h2 class="otp-title">
        OTP Verification
    </h2>

    <p class="otp-text">
        Enter the 6-digit OTP sent to your mobile number.
    </p>

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

    <form action="{{ route('otp.verify') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="form-label">OTP</label>

            <input type="text"
                   name="otp"
                   maxlength="6"
                   class="form-control @error('otp') is-invalid @enderror"
                   placeholder="******">

            @error('otp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-verify w-100">
            <i class="fa-solid fa-shield-halved me-2"></i>
            Verify OTP
        </button>
    </form>

    <div class="text-center mt-4">
        Didn't receive OTP?
        <a href="{{ route('register') }}">Register Again</a>
    </div>

</div>

</body>
</html>