<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>welcome Verified User </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card text-center shadow p-4" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="card-title text-success">Email Verified!</h4>
            <p class="card-text">Your email has been successfully verified. Please click the button below to access your dashboard.</p>
            <a href="{{route('dashboard')}}" class="btn btn-primary">Go to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
