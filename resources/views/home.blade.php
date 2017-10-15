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
            @auth
                <div class="tiles">
                    
                </div>
                <div class="sidebar">
                    <div>
                        @foreach(auth()->user()->latestsEpisodes() as $episode)
                            <div @click="playEpisode('{{ $episode->id }}')">
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
        <audio-player :episode-id="episode"></audio-player>
    </div>

    @routes
    <script src="{{ mix('app.js') }}"></script>
@stop