<template>
    <div class="bg-white shadow border-t">
        <div class="flex" v-if="episode">
            <div class="flex-1 px-2 py-1">
                <div class="flex items-center mb-1">
                    <div class="select-none text-xs">{{ humanTime }}</div>
                    <div class="flex-1 px-2">
                        <div class="h-2 w-full rounded cursor-pointer border" id="progress-bar" @click="setTime">
                            <span class="bg-orange block h-full" :style="{width: barDuration}"></span>
                        </div>
                    </div>
                    <div class="select-none text-xs">{{ humanLength }}</div>
                </div>
                <div class="text-center">
                    <span class="mr-1">{{ episode.title }}</span>
                    <span class="text-xs uppercase text-grey-darker">- {{ episode.podcast.title }}</span>
                </div>
            </div>
            <div class="border-l hidden md:flex items-center group relative">
                <div class="h-10 w-10 p-2 cursor-pointer">
                    <svg v-if="volume == 0"       class="h-full w-full fill-current text-orange" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 8.59l-2.12-2.13-1.42 1.42L13.6 10l-2.13 2.12 1.42 1.42L15 11.4l2.12 2.13 1.42-1.42L16.4 10l2.13-2.12-1.42-1.42L15 8.6zM4 7H0v6h4l5 5V2L4 7z"/></svg>
                    <svg v-else-if="volume <= 40" class="h-full w-full fill-current text-orange" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 7H3v6h4l5 5V2L7 7zm8.54 6.54l-1.42-1.42a3 3 0 0 0 0-4.24l1.42-1.42a4.98 4.98 0 0 1 0 7.08z"/></svg>
                    <svg v-else                   class="h-full w-full fill-current text-orange" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 7H1v6h4l5 5V2L5 7zm11.36 9.36l-1.41-1.41a6.98 6.98 0 0 0 0-9.9l1.41-1.41a8.97 8.97 0 0 1 0 12.72zm-2.82-2.82l-1.42-1.42a3 3 0 0 0 0-4.24l1.42-1.42a4.98 4.98 0 0 1 0 7.08z"/></svg>
                </div>
                <div class="invisible group-hover:visible absolute pin-b-100 bg-white shadow p-2 w-full flex justify-center">
                    <div class="vertical-range-wrapper">
                        <input v-model.number="volume" type="range" min="0" max="100" @change="setVolume" class="vertical-range">
                    </div>
                </div>
            </div>
            <div class="border-l flex items-center">
                <button @click="togglePlay()" id="playButton" class="h-12 w-12">
                    <svg v-show="isPlaying" class="h-full w-full fill-current text-orange" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z"/></svg>
                    <svg v-show="!isPlaying" class="h-full w-full fill-current text-orange" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                </button>
            </div>
        </div>
        
        <audio id="audio-player" :src="audio" class="hidden"></audio>
    </div>
</template>

<script>
    let moment = require('moment');
    import {EventBus} from '../EventBus.js'; 

    export default {
        computed: {
            humanTime: function() {
                return this.formatTime(this.duration);
            },
            humanLength: function() {
                return this.formatTime(this.length);
            },
            barDuration: function() {
                return (this.duration / this.length) * 100+'%';
            }
        },

        data() {
            return {
                player: null,
                episode: null,
                audio: null,
                isPlaying: false,
                duration: 0,
                length: 0,
                autoPlay: false,
                volume: 100,
            };
        },

        mounted() {
            this.player = document.getElementById('audio-player');
            this.init();
            this.loadLastEpisode();

            
            document.addEventListener('keydown', e => {
                if (e.target.localName == 'input' || e.target.localName == 'button') {
                    return;
                }

                if (e.keyCode == 0 || e.keyCode == 32) {
                    if (e.target == document.body) {
                        e.preventDefault();
                    }
                    this.togglePlay();
                }
            });
        },

        methods: {
            togglePlay() {
                if (this.player.src == '') {
                    return;
                }

                if (this.isPlaying) {
                    this.player.pause();
                } else {
                    this.player.play();
                }
            },

            loadDuration() {
                axios.get(route('completions.show', this.episode.id)).then((response) => {
                    if (response.data != "") {
                        this.player.currentTime = response.data.data.duration - 3;  // Remove 3 sec for user to remeber where they left off.
                    }
                });
            },

            updateTime() {
                if (this.episode != null) {
                    axios.put(route('completions.update', this.episode.id), {time: this.duration});  
                }
            },

            formatTime(seconds) {
                let duration = moment.duration(parseInt(seconds), 'seconds');
                return _.padStart(Math.floor(duration.asMinutes()), 2, 0)+moment.utc(duration.asMilliseconds()).format(":ss", { trim: false });
            },

            setTime(event) {
                let bar = (event.target.id == 'progress-bar') ? event.target : (event.target.parentNode.id == 'progress-bar' ? event.target.parentNode : null);
                this.player.currentTime = this.length / bar.offsetWidth * event.offsetX;
            },

            setVolume() {
                this.player.volume = this.volume / 100;
            },

            init() {
                this.player.addEventListener('play', () => {
                    this.isPlaying = true;
                });
                this.player.addEventListener('pause', () => {
                    this.isPlaying = false;
                    this.updateTime();
                });
                this.player.addEventListener('timeupdate', () => {
                    this.duration = this.player.currentTime;
                });
                this.player.addEventListener('loadeddata', () => {
                    this.length = parseInt(this.player.duration);
                    if (this.autoPlay) {
                        this.player.play();
                        this.autoPlay = false;
                    }
                });
                this.player.addEventListener('ended', () => {
                    this.isPlaying = false;
                    axios.put(route('completions.update', this.episode.id), {complete: true});
                });
                window.addEventListener('beforeunload', () => {
                    this.updateTime();
                });
                EventBus.$on('playEpisode', (episode) => {
                    if (this.episode && this.episode.id == episode.id) {
                        this.player.play();
                        return;
                    }

                    this.episode = episode;
                    this.autoPlay = true;
                    this.audio = episode.audio;
                    this.loadDuration();

                    document.title = this.episode.title+" | Podsai";
                });
            },

            loadLastEpisode() {
                axios.get(route('completions.index')).then(res => {
                    if (res.data != '') {
                        this.episode = res.data.data.episode;
                        this.audio = res.data.data.episode.audio;
                        this.player.currentTime = res.data.data.duration;
                    }
                });
            },
        },
    }
</script>