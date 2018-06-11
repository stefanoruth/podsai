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
                    <div>
                        <div class="mb-1">{{ episode.title }}</div>
                        <div class="flex">
                            <div class="mr-4">
                                <svg class="align-bottom h-4 w-4 fill-current text-grey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11 9h2v2H9V7h2v2zm-5.82 6.08a6.98 6.98 0 0 1 0-10.16L6 0h8l.82 4.92a6.98 6.98 0 0 1 0 10.16L14 20H6l-.82-4.92zM10 15a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/></svg>
                                <span class="text-sm">{{ episode.length }}</span>
                            </div>
                            <div>
                                <svg class="align-bottom h-4 w-4 fill-current text-grey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"/></svg>
                                <span class="text-sm">{{ episode.published_at}}</span>
                            </div>
                        </div>
                    </div>
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