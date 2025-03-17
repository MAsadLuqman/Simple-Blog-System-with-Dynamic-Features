<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"> <!-- Link to external CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
<div class="login-general">
    <div class="logo-container">
        <img src="{{asset('/image/hybrid_web_logo.png')}}" alt="Company Logo" class="logo">
    </div>
    <div class="login-card">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Login</h4>
            </div>

            <div class="card-body">
                <form action="{{route('login_match')}}" method="get">
                    @csrf
                    <div class="mb-3 input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control" id="loginEmail" value="{{ old('email') }}" placeholder="Enter your email">
                        @error('email')
                        <span class="alert text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Enter your password" value="{{old('email')}}">
                    </div>
                    <div>
                        @error('password')
                        <span class="alert text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Forgot Password Link -->
                    <p class="text-end">
                        <a href="{{route('password.reset')}}" class="text-decoration-none">Forgot Password?</a>
                    </p>

                    <button type="submit" class="btn btn-primary w-100">Login</button>


                    <p class="text-center mt-3">
                        Don't have an account? <a href="{{route('register')}}">Register</a>
                    </p>
                    <div>
                        <p class="text-center fw-bold">Or <br> Login With</p>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <!-- Google Login -->
                        <a href="{{ route('login.google') }}" class="btn btn-light border shadow-sm d-flex align-items-center px-3">
                            <i class="fab fa-google text-danger me-2"></i> Google
                        </a>

                        <!-- Facebook Login -->
                        <a href="#" class="btn btn-primary d-flex align-items-center px-3 text-white">
                            <i class="fab fa-facebook-f me-2"></i> Facebook
                        </a>

                        <!-- GitHub Login -->
                        <a href="{{route('login.github')}}" class="btn btn-dark d-flex align-items-center px-3 text-white">
                            <i class="fab fa-github me-2"></i> GitHub
                        </a>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

@if (Session::has('success'))
        $(document).ready(function (){
            toastr.options = {
                "progressBar" : true,
            }
            toastr.success("{{ Session::get('success') }}");
        });
@endif

@if (Session::has('error'))
        $(document).ready(function (){
            toastr.options = {
                "progressBar" : true,
            }
            toastr.error("{{ Session::get('error') }}");
        });
@endif
</script>
</body>
</html>
