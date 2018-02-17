<template>
    <div v-if="episode != null" class="mx-auto max-w-2xl px-4 py-8">
        <div class="md:flex">
            <div class="flex justify-center md:block md:pr-8 md:w-1/4 mb-4">
                <episode-image :episode="episode"></episode-image>
            </div>
            <div class="flex-1">
                <div class="bg-white shadow mb-4 p-4">
                    <div class="text-3xl text-black font-bold mb-2">{{ episode.title }}</div>
                    <div class="flex mb-4">
                        <div class="pr-2">{{ episode.length }}</div>
                        <div>{{ episode.published_at }}</div>
                    </div>
                    <div class="">
                        <button class="btn-primary" @click="playEpisode(episode)">Listen</button>
                    </div>
                </div>
                <div class="content bg-white p-4 shadow" v-if="episode.show_notes" v-html="episode.show_notes"></div>
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