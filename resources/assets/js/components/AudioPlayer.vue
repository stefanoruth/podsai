<template>
    <div class="player" v-show="episode != null">
        <div class="bar" v-on:mousemove="showTime" v-on:mouseleave="hideTime" @click="setTime">
            <span class="progress" :style="{width: barDuration}"></span>
            <span class="tooltip" :style="{left: tooltipOffset}" v-show="tooltip != null">{{ tooltip }}</span>
        </div>
        <div>
            
            <img style="float:left;" v-if="episode != null" :src="episode.podcast.logo">
            <div>
                <button @click="togglePlay()">{{ isPlaying ? 'Pause' : 'Play' }}</button>
            <span>{{ humanTime }} / {{ humanLength }}</span>
            <button @click="close()">Close</button>
            <p v-if="episode != null">{{ episode.title }}</p>
            </div>

            <audio id="audio-player" autoplay="" :src="audio" style="display:none;"></audio>
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
                durationPercentage: '0%',
                tooltip: null,
                tooltipOffset: '-10px',
            };
        },

        mounted() {
            this.player = document.getElementById('audio-player');
            this.init();
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

            loadEpisode(id) {
                axios.get(route('completions.show', id)).then((response) => {
                    this.player.currentTime = (response.data.data.duration - 3); // Remove 3 sec for user to remeber where they left off.
                    this.episode = response.data.data.episode;
                }).catch((error) => {
                    if (error.response.status != 404) {
                        throw error;
                    }

                    axios.post(route('completions.store'), {id: id}).then((response) => {
                        this.episode = response.data.data;
                    });
                });
            },

            updateTime() {
                if (this.episode != null) {
                    axios.put(route('completions.update', this.episode.id), {time: this.duration});  
                }
            },

            completeEpisode() {
                axios.put(route('completions.update', this.episode.id), {complete: true});
            },

            formatTime(seconds) {
                let duration = moment.duration(parseInt(seconds), 'seconds');
                return _.padStart(Math.floor(duration.asMinutes()), 2, 0)+moment.utc(duration.asMilliseconds()).format(":ss", { trim: false });
            },

            setTime(event) {
                this.player.currentTime = this.length / _.find(event.path, (item) => {return item.className == 'bar';}).offsetWidth * event.layerX;
            },

            showTime(event) {
                let seconds = this.length / _.find(event.path, (item) => {return item.className == 'bar';}).offsetWidth * event.layerX;
                this.tooltip = this.formatTime(seconds);
                this.tooltipOffset = (event.layerX - 24)+'px';
            },

            close() {
                this.player.pause();
                this.episode = null;
            },

            hideTime(event) {
                this.tooltip = null;
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
                });
                this.player.addEventListener('ended', () => {
                    this.isPlaying = false;
                    this.completeEpisode();
                });
                window.addEventListener('beforeunload', () => {
                    this.updateTime();
                });
                EventBus.$on('playEpisode', (episode) => {
                  this.episode = episode;
                  this.audio = episode.audio;
                });
            },
        },
    }
</script>

<style scoped>
    .player {
        display: flex;
        flex-direction: column;
        background-color: #fff;
        height: 81px;
        border-top: 1px solid #dee0df;
        overflow-y: hidden;
    }

    .bar {
        height: 8px;
        width: 100%;
        background-color: #eee;
        cursor: pointer;
        position: relative;
    }

    .progress {
        background: linear-gradient(to right, #2383ae, #6dd7b9);
        height: 100%;
        width: 0%;
        display: block;
        border-radius: 0px;
    }

    .tooltip {
        display: block;
        position: absolute;
        bottom: calc(100% + 10px);
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        width: 50px;
        padding: 2px 0px;
        text-align: center;
        border-radius: 5px;
    }
</style>