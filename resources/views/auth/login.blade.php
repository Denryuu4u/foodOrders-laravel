<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — WEB-SYY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #212529; color: #fff; }
    </style>
</head>
<body class="bg-dark text-white">

    <div class="container-fluid py-3 pt-4 px-4">
        <a href="{{ route('register') }}" class="text-white text-decoration-none fw-bold">
            <i class="bi bi-arrow-left"></i> Register
        </a>
    </div>

    <section class="container d-flex align-items-center" style="min-height: 85vh;">
        <div class="row w-100 justify-content-center">
            <div class="col-md-5">
                <div class="border border-light p-4 rounded">
                    <h1 class="mb-1">LOGIN PAGE</h1>
                    <p class="text-secondary mb-4">Sign in to your account</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" placeholder="Enter email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password:</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" placeholder="Enter password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Remember me
                            </label>
                        </div>
                        <p class="mb-3">Don't have an account yet? 
                            <a href="{{ route('register') }}" class="text-light">Sign up here</a>
                        </p>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Toast for success (e.g. after registration redirect) --}}
    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const el = document.getElementById('successToast');
            if (el) new bootstrap.Toast(el, { delay: 4000 }).show();
        });
    </script>
</body>
</html>
