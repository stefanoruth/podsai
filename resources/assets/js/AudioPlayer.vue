<template>
    <div class="audio-player">
        <button @click="togglePlay()">{{ isPlaying ? 'Pause' : 'Play' }}</button>
        <p>{{ humanTime }}<br>{{ humanLength }}</p>
        <div class="bar"><span :style="{width:barDuration}"></span></div>
        <audio id="audio-player" autoplay="" :src="file" style="display:none;"></audio>
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
                return moment().startOf('day').seconds(parseInt(this.duration)).format('H:mm:ss');
            },
            humanLength: function() {
                return moment().startOf('day').seconds(this.length).format('H:mm:ss');
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
                if (this.isPlaying) {
                    this.player.pause();
                } else {
                    this.player.play();
                }
            },
        },
    }
</script>

<style scoped>
    .bar {
        height: 10px;
        width: 300px;
        border: 1px solid #000;
    }

    .bar span {
        background-color: red;
        height: 100%;
        width: 0%;
        display: block;
    }
</style>