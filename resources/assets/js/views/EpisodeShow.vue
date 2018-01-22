<template>
    <div class="mx-auto max-w-md p-4" v-if="episode != null">
        <div class="w-full shadow rounded bg-white">
            <div class="flex">
                <div class="h-32 w-32 flex-none bg-cover overflow-hidden" v-bind:style="{'background-image':'url('+episode.podcast.logo+')'}"></div>
                <div class="p-4">
                    <div class="mb-2">
                        <div class="text-lg font-bold mb-2">{{ episode.title }}</div>
                        <div>{{ episode.length }}</div>
                    </div>
                    <div>
                        <button class="bg-grey hover:bg-grey-dark text-white font-bold py-1 px-2 rounded" @click="playEpisode(episode)">Play</button>
                    </div>
                </div>
            </div>
            <div class="p-4 content" v-if="episode.show_notes != null" v-html="episode.show_notes"></div>
            <div class="p-4 content" v-else v-html="episode.description"></div>
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
            axios.get(route('episodes.show', {episode: this.id, podcast: this.podcast})).then((response) => {
                this.episode = response.data.data;
            });
        },

        methods: {
            playEpisode: EventBus.playEpisode,
        },
    }
</script>