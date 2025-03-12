<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/style.css"> <!-- Link to external CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
<div class="login-general">
    <div class="logo-container">
        <img src="/image/hybrid_web_logo.png" alt="Company Logo" class="logo">
    </div>
    <div class="login-card">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Update Password</h4>
            </div>

            <div class="card-body">
                <form action="{{route('update_password',$userId)}}" method="post">
                    @csrf
                    <div class="mb-3 input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Enter your password">
                        @error('password')
                        <span class="alert text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" class="form-control" id="registerPassword" placeholder="Enter your password">
                        @error('conformation_password')
                        <span class="alert text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>

                    @if (Session::has('success'))
                        <script>
                            $(document).ready(function (){
                                toastr.options = {
                                    "progressBar" : true,
                                }
                                toastr.success("{{ Session::get('success') }}");
                            });
                        </script>
                    @endif

                    @if (Session::has('error'))
                        <script>
                            $(document).ready(function (){
                                toastr.options = {
                                    "progressBar" : true,
                                }
                                toastr.error("{{ Session::get('error') }}");
                            });
                        </script>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
