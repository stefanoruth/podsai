<template>
    <div v-if="episode != null" class="mx-auto max-w-2xl px-4 py-8">
        <div class="md:flex">
            <div class="flex justify-center md:block md:pr-8 md:w-1/4 mb-4">
                <img class="h-32 w-32 md:h-auto md:w-full shadow-md" :src="episode.podcast.logo">
            </div>
            <div class="flex-1">
                <div class="text-3xl text-black font-bold mb-4">{{ episode.title }}</div>
                <div class="mb-4">
                    <button class="btn" @click="playEpisode(episode)">Listen</button>
                </div>
                <div class="content" v-html="episode.show_notes"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '../EventBus.js';

    export default {
        props: ['episodeId', 'podcastId'],

        data() {
            return {
                episode: null,
            };
        },

        mounted() {
            axios.get(route('episodes.show', {episode: this.episodeId, podcast: this.podcastId})).then((response) => {
                this.episode = response.data.data;
            });
        },

        methods: {
            playEpisode: EventBus.playEpisode,
        },
    }
</script>