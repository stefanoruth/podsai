<template>
    <div class="fixed pin-b pin-x bg-grey" v-show="episode != null">
        <div class="block w-full" v-if="episode != null">
            <div class="h-4 w-full block border-b border-grey-lighter cursor-pointer" id="progress-bar" @click="setTime">
                <span class="bg-grey-darker block h-full" :style="{width: barDuration}"></span>
            </div>
            <div class="flex">
                <img class="w-12 h-12 m-2 border" :src="episode.podcast.logo">
                <div class="m-2 flex-1 flex">
                    <div class="flex-1">
                        <div class="text-sm">{{ humanTime }} / {{ humanLength }}</div>
                        <div class="text-lg">{{ episode.title }}</div>
                    </div>
                    <div>
                        <button @click="togglePlay()" class="h-12 w-12">
                            <svg v-show="isPlaying" class="h-full w-full fill-current text-grey-darkest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z"/></svg>
                            <svg v-show="!isPlaying" class="h-full w-full fill-current text-grey-darkest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <audio id="audio-player" :src="audio" style="display:none;"></audio>
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
            };
        },

        mounted() {
            this.player = document.getElementById('audio-player');
            this.init();

            
            document.addEventListener('keydown', e => {
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
                this.player.currentTime = this.length / _.find(event.path, (item) => {return item.id == 'progress-bar';}).offsetWidth * event.layerX;
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
                    this.player.play();
                });
                this.player.addEventListener('ended', () => {
                    this.isPlaying = false;
                    axios.put(route('completions.update', this.episode.id), {complete: true});
                });
                window.addEventListener('beforeunload', () => {
                    this.updateTime();
                });
                EventBus.$on('playEpisode', (episode) => {
                    this.episode = episode;
                    this.audio = episode.audio;
                    this.loadDuration();

                    document.title = this.episode.title+" | Podsai";
                });
            },
        },
    }
</script>