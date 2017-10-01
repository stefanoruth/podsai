<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    @guest
        <a href="{{ url('login/google') }}">Login using Google</a>
    @endguest
    @auth
        <a href="{{ url('logout') }}">Logout</a>
        {{ auth()->user()->name }}
    @endauth
</body>
</html>