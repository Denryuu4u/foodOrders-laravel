<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — WEB-SYY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #212529; color: #fff; }
    </style>
</head>
<body class="bg-dark text-white">

    <div class="container-fluid py-3 pt-4 px-4">
        <a href="{{ route('login') }}" class="text-white text-decoration-none fw-bold">
            <i class="bi bi-arrow-left"></i> Back to Login
        </a>
    </div>

    <section class="container d-flex align-items-center" style="min-height: 85vh;">
        <div class="row w-100 justify-content-center">
            <div class="col-md-5">
                <div class="border border-light p-4 rounded">
                    <h1 class="mb-1">REGISTER</h1>
                    <p class="text-secondary mb-4">Create a new account</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <div class="mb-4">
                            <label class="form-label">Confirm Password:</label>
                            <input type="password" class="form-control"
                                   name="password_confirmation" placeholder="Confirm password" required>
                        </div>
                        <p class="mb-3">Already have an account? 
                            <a href="{{ route('login') }}" class="text-light">Login here</a>
                        </p>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-person-plus-fill me-1"></i> Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
