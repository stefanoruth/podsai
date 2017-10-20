@extends('app')

@section('body')
    <div id="app">
        <div class="header-border"></div>
        <div class="header">
            <search-field></search-field>
            <div class="user">{{ auth()->user()->name ?? 'Guest' }}</div>
        </div>
        <main>
            <router-view></router-view>
        </main>
        <audio-player :episode-id="episode"></audio-player>
    </div>

    @routes
    <script src="{{ mix('app.js') }}"></script>
@stop