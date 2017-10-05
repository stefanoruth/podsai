<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('app.css') }}">
</head>
<body>
    <div id="app">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <div class="search">
                <input type="text" placeholder="Search">
            </div>
            <div class="player">
                <audio-player :file="audioFile"></audio-player>
            </div>
            <div class="user">{{ auth()->user()->name ?? 'Guest' }}</div>
        </div>
        <main>
            <div class="tiles">
                
            </div>
            <div class="sidebar">
                @auth
                    <ul>
                        @foreach(auth()->user()->latestsEpisodes() as $episode)
                            <li @click="playEpisode('{{ $episode->audio }}')" style="margin-bottom: 5px;" data-audio="{{ $episode->audio }}"><strong>{{ $episode->podcast->title }}</strong> - {{ $episode->title }} - {{ $episode->published_at->format('d/m-Y H:i:s') }}</li>
                        @endforeach
                    </ul>
                @endauth
            </div>
        </main>
    </div>
    <script src="{{ mix('app.js') }}"></script>
</body>
</html>