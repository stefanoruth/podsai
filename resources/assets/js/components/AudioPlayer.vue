<template>
    <div v-if="episode" class="border-t bg-white">
        <div class="flex items-center p-2 max-w-md mx-auto">
            <div class="flex-1 flex cursor-pointer pr-2" @click="mini = false">
                <div>
                <img class="w-12 h-12 block shadow-md rounded-lg" :src="episode.podcast.logo" :alt="episode.podcast.title">
            </div>
            <div class="flex-1 px-2 flex flex-col justify-center">
                <div class="no-underline text-black">{{ episode.title }}</div>
                <div class="no-underline text-grey">{{ episode.podcast.title }}</div>
            </div>
            </div>
            <div class="flex items-center">
                <button class="w-8 h-8 rounded-full shadow bg-purple p-2" @click="togglePlay">
                    <svg v-show="player.paused"  class="w-full h-full fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                    <svg v-show="!player.paused" class="w-full h-full fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z"/></svg>
                </button>
            </div>
        </div>
        
        <div class="fixed pin bg-white z-40" :class="{hidden: mini}">
            <div class="max-w-md mx-auto p-4">
                <div class="flex mb-4">
                    <div class="flex-1">
                        <img class="rounded-lg shadow-lg w-full" :src="episode.podcast.logo" :alt="episode.podcast.title">
                    </div>
                    <div>
                        <div>
                            <button class="p-2" @click="mini = true">                 
                                <svg class="w-8 h-8 fill-current text-grey-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="mb-1">
                        <div class="h-1 w-full cursor-pointer relative bg-grey-light" id="progress-bar" @click="setTime">
                            <div class="bg-purple h-full pin-t pin-l absolute" :style="{width: barDuration}">
                                <div class="absolute h-3 w-3 rounded-full bg-purple" style="top: -0.25rem;right: -0.375rem;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between text-sm font-light">
                        <div>{{ humanTime }}</div>
                        <div>{{ humanLength }}</div>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <div class="text-xl mb-1">{{ episode.title }}</div>
                    <div class="text-grey-darker">{{ episode.podcast.title }}</div>
                </div>

                <div class="flex justify-center mb-6">
                    <button class="w-12 h-12 rounded-full shadow bg-purple p-2" @click="togglePlay">
                        <svg v-show="player.paused"  class="w-full h-full fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        <svg v-show="!player.paused" class="w-full h-full fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z"/></svg>
                    </button>
                </div>

                <div class="flex items-center text-sm font-light">
                    <div class="pr-2">    
                        <svg class="w-4 h-4 fill-current text-grey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 7H3v6h4l5 5V2L7 7zm8.54 6.54l-1.42-1.42a3 3 0 0 0 0-4.24l1.42-1.42a4.98 4.98 0 0 1 0 7.08z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="h-1 w-full cursor-pointer relative bg-grey-light" id="volume-bar" @click="setVolume">
                            <div class="bg-purple h-full pin-t pin-l absolute" :style="{width: barVolume}">
                                <div class="absolute h-4 w-4 rounded-full bg-white shadow" style="top: -0.5rem;right: -0.5rem;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-2">           
                        <svg class="w-4 h-4 fill-current text-grey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 7H1v6h4l5 5V2L5 7zm11.36 9.36l-1.41-1.41a6.98 6.98 0 0 0 0-9.9l1.41-1.41a8.97 8.97 0 0 1 0 12.72zm-2.82-2.82l-1.42-1.42a3 3 0 0 0 0-4.24l1.42-1.42a4.98 4.98 0 0 1 0 7.08z"/></svg>
                    </div>
                </div>
            </div>
        </div>
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
                return (this.duration / this.length) * 100 + '%';
            },
            barBuffered: function() {
                return (this.buffered / this.length) * 100 + '%';
            },
            barVolume: function() {
                return this.volume*100 + '%';
            },
        },

        data() {
            return {
                player: null,
                episode: null,
                duration: 0,
                length: 0,
                autoPlay: false,
                buffered: 0,
                isLoading: false,
                isPlaying: false,
                volume: 1,
                mini: true,
            };
        },

        mounted() {
            this.player = new Audio;
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

                if (this.player.paused) {
                    this.player.play();
                } else {
                    this.player.pause();
                }
            },

            loadDuration() {
                axios.get(route('completions.show', this.episode.id)).then((response) => {
                    if (response.data != "") {
                        this.player.currentTime = response.data.data.duration - 3;  // Remove 3 sec for user to remeber where they left off.
                    }
                });
            },

            getBufferState() {
                if (this.player.buffered.length > 0) {
                    this.buffered = this.player.buffered.end(this.player.buffered.length - 1);
                }
            },

            saveDuration() {
                if (this.episode != null && !this.player.ended) {
                    axios.put(route('completions.update', this.episode.id), {time: this.duration});
                }
            },

            finishEpisode() {
                axios.put(route('completions.update', this.episode.id), {complete: true});
                this.episode = null;
            },

            formatTime(seconds) {
                let duration = moment.duration(parseInt(seconds), 'seconds');
                return _.padStart(Math.floor(duration.asMinutes()), 2, 0)+moment.utc(duration.asMilliseconds()).format(":ss", { trim: false });
            },

            setTime(event) {
                // missing example with indicator target.
                let bar = (event.target.id == 'progress-bar') ? event.target : (event.target.parentNode.id == 'progress-bar' ? event.target.parentNode : null);
                this.player.currentTime = this.length / bar.offsetWidth * event.offsetX;
            },

            setVolume() {
                let bar = (event.target.id == 'volume-bar') ? event.target : (event.target.parentNode.id == 'volume-bar' ? event.target.parentNode : null);
                this.player.volume = event.offsetX / bar.offsetWidth;
            },

            setEpisode(episode) {
                this.episode = episode
                this.player.src = episode.audio;
                this.player.load();
                document.title = episode.title + ' | Podsai';
            },

            init() {
                this.player.addEventListener('play', () => {
                    this.isPlaying = true;
                });

                this.player.addEventListener('playing', () => {
                    this.isPlaying = true;
                });

                this.player.addEventListener('pause', () => {
                    this.saveDuration();
                    this.isPlaying = false;
                });

                this.player.addEventListener('timeupdate', () => {
                    this.duration = this.player.currentTime;
                });

                this.player.addEventListener('loadeddata', () => {
                    this.length = parseInt(this.player.duration);
                });

                this.player.addEventListener('canplay', () => {
                    this.isLoading = false;

                    if (this.autoPlay) {
                        this.player.play();
                        this.autoPlay = false;
                    }
                });

                this.player.addEventListener('waiting', () => {
                    this.isLoading = true;
                });

                this.player.addEventListener('ended', () => {
                    this.finishEpisode();
                });
                
                this.player.addEventListener('volumechange', () => {
                    this.volume = this.player.volume;
                });

                // onprogress event doesn't seem to be fully supported
                setInterval(this.getBufferState, 1000);

                window.addEventListener('beforeunload', () => {
                    this.saveDuration();
                });

                EventBus.$on('playEpisode', (episode) => {
                    if (this.episode && this.episode.id == episode.id) {
                        this.player.play();
                        return;
                    }

                    this.autoPlay = true;
                    this.length = 0;
                    this.player.currentTime = 0;
                    this.setEpisode(episode);
                    this.loadDuration();
                });
            },

            loadLastEpisode() {
                axios.get(route('completions.index')).then(res => {
                    if (res.data != '') {
                        this.setEpisode(res.data.data.episode);
                        this.player.currentTime = res.data.data.duration;
                    }
                });
            },
        },
    }
</script>