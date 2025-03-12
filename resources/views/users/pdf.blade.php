<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Pdf Maker</title>

    <style>
        table,th,td{
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;font-weight: bold">Hybrid Media Works</h1>
    <h3 style="text-align: center; margin-top: 20px">Users Lists</h3>
    <p><span style="font-weight: bold">Date & Time:</span>{{$date}}</p>
    <p>Gendered By:{{auth()->user()->name}}</p>

    <table>
        <thead style="background-color: black; color: white">
        <tr>
            <th>ID</th>
            <th>name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr style="text-align: center">
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>
