<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
            <td>Dear {{ $name }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Please Click on below link to Active your Account</td>
        </tr>
        <tr>
            <td>
                <a href="{{url('/user/confirm/'.$code)}}">Confirm Account</a>
            </td>
        </tr>
        <tr>
            <td>Mobile: {{ $mobile }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Email: {{ $email }}</td>
        </tr>
    </table>
</body>

</html>
