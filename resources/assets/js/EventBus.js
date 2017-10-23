import Vue from 'vue';
export const EventBus = new Vue({
    methods: {
        playEpisode(episode) {
            this.$emit('playEpisode', episode);
        },
    },
});