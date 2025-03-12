<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to external CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<div class="login-general">
    <div class="logo-container">
        <img src="image/hybrid_web_logo.png" alt="Company Logo" class="logo">
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="text-center">Register</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('register_save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" class="form-control" id="registerName" placeholder="Enter your full name" value="{{old('name')}}">
                            @error('name')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 input-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" class="form-control" id="registerEmail" value="{{old('email')}}" placeholder="Enter your email">
                            @error('email')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 input-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Enter your password">
                            @error('password')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 input-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" class="form-control" id="registerPassword" placeholder="Enter your password">
                            @error('conformation_password')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="file-input-container">
                                <input type="file" name="image" class="form-control file-input" id="profilePic" accept="image/*" onchange="previewProfile(event)">
                                <label for="profilePic" class="file-input-label">
                                    <i class="fas fa-camera"></i> Choose Image
                                </label>
                        </div>
                            @error('image')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input_file_section">
                            <div class="profile-preview">
                                <img id="profilePreview"  >
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Custom File Input for Profile Picture -->

                <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
                <p class="text-center mt-3">
                    Already have an account? <a href="{{route('login')}}">Login</a>
                </p>
            </form>
        </div>
    </div>
</div>
<script>
    function previewProfile(event) {
        let profilePreview = document.getElementById("profilePreview");
        let file = event.target.files[0];

        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>
