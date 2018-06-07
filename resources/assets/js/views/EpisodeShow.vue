<template>
    <div v-if="episode != null" class="mx-auto max-w-md flex items-center py-4 px-2">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex">
                <div>
                    <router-link :to="'/podcasts/'+episode.podcast.id" class="block">
                        <img class="w-16 h-16 block shadow-md rounded-lg" :src="episode.podcast.logo" :alt="episode.podcast.title">
                    </router-link>
                </div>
                <div class="flex-1 flex flex-col justify-center px-2">
                    <episode-info :episode="episode"></episode-info>
                </div>
                <div class="flex items-center">
                    <button class="w-10 h-10 rounded-full shadow bg-purple p-2" @click="playEpisode(episode)">
                        <svg class="w-full h-full fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                    </button>
                </div>
            </div>
            <div class="content border-t pt-4 mt-4 border-grey" v-if="episode.show_notes" v-html="episode.show_notes"></div>
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

            completeEpisode() {
                if (this.episode.completion == null || this.episode.completion.completed == false) {
                    axios.put(route('completions.update', this.episode.id), {complete: true}).then((response) => {
                        this.episode.completion =  response.data.data;
                    });
                } else if (this.episode.completion.completed) {
                    axios.delete(route('completions.destroy', this.episode.id)).then(() => {
                        this.episode.completion.completed = false;
                    });
                }
            },
        },
    }
</script>