<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
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
.card-box{
    width:450px;
    background:#fff;
    padding:35px;
    border-radius:15px;
    box-shadow:0 15px 35px rgba(0,0,0,.2);
}
.form-control{
    height:48px;
    border-radius:10px;
}
.btn-save{
    background:#4f46e5;
    color:#fff;
    height:48px;
    border-radius:10px;
}
.btn-save:hover{
    background:#4338ca;
    color:#fff;
}
.input-group .form-control{
    height:48px;
    border-radius:10px 0 0 10px;
}


.input-group .btn{
    border:1px solid #dee2e6;
    background:#fff;
    color:#6c757d;
}

.input-group .btn:hover{
    background:#6c757d;
    color:#fff;
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

<div class="card-box">
    <div id="forgotLoader">
        <div class="spinner-border text-primary"></div>
    </div>
    <h2 class="text-center mb-4">Reset Password</h2>

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

    <form id="forgotForm"    action="{{ route('reset.password') }}" method="POST">
    @csrf

        <div class="mb-3">
            <label>New Password</label>

            <div class="input-group">
                <input type="password"
                    name="password"
                    minlength="6"
                    maxlength="20"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter New Password">

                <button class="btn btn-outline-secondary toggle-password"
                        type="button">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            @error('password')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label>Confirm Password</label>

                <div class="input-group">
                    <input type="password"
                        name="password_confirmation"
                        minlength="6"
                        maxlength="20"
                        class="form-control"
                        placeholder="Confirm Password">

                    <button class="btn btn-outline-secondary toggle-password"
                            type="button">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
        </div>

        <button class="btn btn-save w-100">
            Reset Password
        </button>

    </form>

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

    document.getElementById('forgotForm').addEventListener('submit', function () {
        document.getElementById('forgotLoader').style.display = 'flex';
    });
    
</script>

</body>
</html>