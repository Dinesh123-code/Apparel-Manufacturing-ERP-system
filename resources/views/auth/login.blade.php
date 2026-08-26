<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Bundle ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px rgba(0,0,0,.3);
        }
        .brand-icon {
            width: 52px; height: 52px; border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: #fff; margin: 0 auto 16px;
        }
        .form-control {
            border-radius: 8px; font-size: 14px;
            border-color: #e2e8f0; padding: 10px 14px;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }
        .btn-primary {
            background: #2563eb; border: none;
            border-radius: 8px; padding: 11px; font-weight: 600;
            font-size: 14px; transition: all .2s;
        }
        .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }
        .input-icon { position: relative; }
        .input-icon i {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 15px;
        }
        .input-icon .form-control { padding-left: 36px; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="text-center mb-4">
        <div class="brand-icon"><i class="bi bi-layers-fill"></i></div>
        <h5 class="fw-700 mb-0">ERP Management</h5>
        <p class="text-muted" style="font-size:13px;">Apparel Manufacturing System</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger py-2" style="font-size:13px;">
            {{ $errors->first() }}
        </div>
        @endif

        <div class="mb-3">
            <label class="form-label" style="font-size:13px; font-weight:500;">Email Address</label>
            <div class="input-icon">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label" style="font-size:13px; font-weight:500;">Password</label>
            <div class="input-icon">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••" required>
            </div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember" style="font-size:13px;">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
        </button>
    </form>

    <p class="text-center text-muted mt-3 mb-0" style="font-size:12px;">
        &copy; {{ date('Y') }} Bundle ERP — Apparel Manufacturing
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
