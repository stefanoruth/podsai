<template>
    <div class="player" v-show="file != null">
        <div class="bar" v-on:mousemove="showTime" v-on:mouseleave="hideTime" @click="setTime">
            <span class="progress" :style="{width: barDuration}"></span>
            <span class="tooltip" :style="{left: tooltipOffset}" v-show="tooltip != null">{{ tooltip }}</span>
        </div>
        <div>
            <button @click="togglePlay()">{{ isPlaying ? 'Pause' : 'Play' }}</button>
            <span>{{ humanTime }} / {{ humanLength }}</span>
        
            <audio id="audio-player" autoplay="" :src="file" style="display:none;"></audio>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        props: {
            file: {
                type: String,
                default: null,
            }
        },

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
            this.player.addEventListener('play', () => {
                this.isPlaying = true;
            });
            this.player.addEventListener('pause', () => {
                this.isPlaying = false;
            });
            this.player.addEventListener('timeupdate', () => {
                this.duration = this.player.currentTime;
            });
            this.player.addEventListener('loadeddata', () => {
                this.length = parseInt(this.player.duration);
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
                // this.player.currentTime = seconds;
                // console.log(pos, width, this.length);
            },

            hideTime(event) {
                this.tooltip = null;
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