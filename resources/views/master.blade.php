<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#f6993f">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f6993f">
    <link rel="stylesheet" href="{{ mix('app.css') }}">
</head>
<body class="font-sans bg-grey-lightest">
    @yield('body')
    @routes
    <script async src="{{ mix('app.js') }}"></script>
</body>
</html>