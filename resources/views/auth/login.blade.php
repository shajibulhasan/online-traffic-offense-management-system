<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | OTOMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container auth-container">
        <!-- Display Success or Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="auth-header">
            <div class="logo">
                <i class="fas fa-car"></i> OTOMS
            </div>
            <h5>Online Traffic Offense Management System</h5>
        </div>
        <div class="auth-body">
            <h3 class="form-title">Login to Your Account</h3>
            <form id="loginForm" novalidate action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" autocomplete="email" placeholder="name@example.com" required>
                    <label for="email">Email Address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required minlength="6">
                    <label for="password">Password</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}"  style="text-decoration: none; font-size: 0.9rem; color: #2dce89;">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
            </form>
            <div class="divider">OR</div>

            <div class="form-link">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>




