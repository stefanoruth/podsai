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
        <div class="header-border"></div>
        <div class="header">
            <search-field></search-field>
            <div class="user">{{ auth()->user()->name ?? 'Guest' }}</div>
        </div>
        <main>
            @auth
                <div class="tiles">
                    
                </div>
                <div class="sidebar">
                    <div>
                        @foreach(auth()->user()->latestsEpisodes() as $episode)
                            <div @click="playEpisode('{{ $episode->audio }}')">
                                <img src="{{ $episode->podcast->logo }}" width="50" style="float:left">
                                <div>
                                    <p><strong>{{ $episode->title }}</strong></p>
                                    <p>{{ $episode->podcast->title }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endauth
        </main>
        <audio-player :file="audioFile"></audio-player>
    </div>
    <script src="{{ mix('app.js') }}"></script>
</body>
</html>