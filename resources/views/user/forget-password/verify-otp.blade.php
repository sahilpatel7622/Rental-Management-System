<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            font-size:17px;
            letter-spacing:6px;
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
        .card-box{
            position:relative;
        }

        #forgotLoader{
            display:none;
            position:absolute;
            inset:0;
            background:rgba(255,255,255,.75);
            border-radius:15px;
            justify-content:center;
            align-items:center;
            z-index:99;
        }
    </style>
</head>
<body>

<div class="otp-card">

    <div id="forgotLoader">
        <div class="spinner-border text-primary"></div>
    </div>

    <h2 class="otp-title">Verify OTP</h2>

    <p class="otp-text">
        Enter the OTP sent to your email.
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

    <form id="forgotForm" action="{{ route('verify.email.otp') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label>OTP</label>

            <input type="text"
                   name="otp"
                   maxlength="6"
                   class="form-control @error('otp') is-invalid @enderror"
                   placeholder="Enter 6 Digit OTP">

            @error('otp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-verify w-100">
            Verify OTP
        </button>

    </form>

    <div class="text-center mt-3">
        <a href="{{ route('forget.password') }}">
            Back
        </a>
    </div>

</div>

<script>
document.getElementById('forgotForm').addEventListener('submit', function () {
    document.getElementById('forgotLoader').style.display = 'flex';
});
</script>

</body>
</html>