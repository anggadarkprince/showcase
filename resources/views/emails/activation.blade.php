<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Email Activation</title>
</head>
<body>
    Welcome, {{ $user->name }}
    Please active your account : <a href="{{ url('activation', $user->token) }}">ACTIVATE HERE</a>
</body>
</html>