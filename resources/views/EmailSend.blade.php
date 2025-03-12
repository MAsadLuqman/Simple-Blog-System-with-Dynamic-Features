<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Send</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<h3>Dear {{$user->name}}</h3>
<p>
    Thank you for signing up with <b>Hybrid Media works</b>. To complete your registration, please verify your email address by clicking the button below:
</p>
<a href="{{ $link}}" class="btn btn-primary">Verify Email</a>
<h4>Best Regards,</h4>
<P>Hybrid Media works <br>
    051-64686984 <br>
    <a href="https://hybridmediaworks.com/">www.hybridmediaworks.com</a>
</P>
</body>
</html>

