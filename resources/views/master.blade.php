<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="Your favorite podcasts everywhere.">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png?v=2') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png?v=2') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png?v=2') }}">
    <link rel="manifest" href="{{ asset('manifest.json?v=2') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg?v=2') }}" color="#9561e2">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#9561e2">
    <link rel="stylesheet" href="{{ mix('app.css') }}">
</head>
<body class="font-sans bg-grey-lighter text-black">
    @yield('body')
    <noscript>
        For full functionality of this site it is necessary to enable JavaScript.
        Here are the <a href="https://www.enable-javascript.com/" target="_blank" rel="noopener">
        instructions how to enable JavaScript in your web browser</a>.
    </noscript>
    @routes
    <script async src="{{ mix('app.js') }}"></script>
</body>
</html>
