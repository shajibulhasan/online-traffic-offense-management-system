<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | OTOMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>
<body>
    <div class="container auth-container">
        <!-- Display Success or Error Messages -->
+        @if(session('success'))
+            <div class="alert alert-success">
+                {{ session('success') }}
+            </div>
+        @elseif(session('error'))
+            <div class="alert alert-danger">
+                {{ session('error') }}
+            </div>
+        @endif
        <div class="auth-header">
            <div class="logo">
                <i class="fas fa-car"></i> OTOMS
            </div>
            <h5>Online Traffic Offense Management System</h5>
        </div>
        <div class="auth-body">
            <h3 class="form-title">Create a New Account</h3>
            
            <form id="registerForm" novalidate method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" id="name" placeholder="John" required>
                    <label for="name">Name</label>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" id="regEmail" placeholder="name@example.com" required>
                    <label for="regEmail">Email Address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="form-floating mb-3">
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}" id="phone" placeholder="017XXXXXXXX" required>
                    <label for="phone">Phone</label>
                    @error('phone')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           id="regPassword" placeholder="Password" required minlength="6" autocomplete="new-password">
                    <label for="regPassword">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                           name="password_confirmation" id="confirmPassword" placeholder="Confirm Password" required>
                    <label for="confirmPassword">Confirm Password</label>
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Role -->
                <div class="form-floating mb-3">
                    <select class="form-select @error('role') is-invalid @enderror" name="role" id="userType" required>
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select user type</option>
                        <option value="officer" {{ old('role') == 'officer' ? 'selected' : '' }}>Officer</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    <label for="userType">I am a</label>
                    @error('role')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="number" name="nid" class="form-control @error('nid') is-invalid @enderror"
                           value="{{ old('nid') }}" id="regNid" placeholder="Enter Nid Number" required>
                    <label for="regNid">Nid Number</label>
                    @error('nid')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>

            <div class="divider">Or</div>

            <div class="form-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
