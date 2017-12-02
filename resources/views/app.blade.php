<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('app.css') }}">
    <script>
        window.user = '{{ auth()->user()->name ?? 'Guest' }}';
    </script>
</head>
<body class="font-sans bg-grey-lightest">
    @yield('body')
</body>
</html>