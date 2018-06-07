<template>
    <div v-if="podcast != null" class="mx-auto max-w-md relative">
        <div class="w-full relative">
            <div class="block relative pt-full">
                <img class="w-full h-full absolute pin block" :src="podcast.logo" :alt="podcast.title">
                <div class="absolute pin bg-black" style="opacity: 0.45"></div>
            </div>
            <div class="text-white text-center absolute pin-t w-full pt-12">
                <div class="text-2xl mb-2">{{ podcast.title }}</div>
                <div class="mb-4">{{ podcast.episodes_count }}</div>
                <div class="mb-4">
                    <button @click="subscribe(podcast)" class="border border-white text-white px-2 py-1 rounded-lg">Subscribed</button>
                </div>
                <div class="max-w-sm mx-auto">{{ podcast.description }}</div>
            </div>
        </div>
        <div class="bg-white shadow absolute rounded-lg mx-1 py-4" style="top: 80%">
            <div v-for="episode in podcast.episodes" :key="episode.id" class="flex mb-2 px-2">
                <router-link :to="'/podcasts/'+podcast.id+'/episodes/'+episode.id" class="flex-1 pr-2 no-underline text-black">
                    <episode-info :episode="episode"></episode-info>
                </router-link>
                <div class="flex items-center">
                    <button class="w-8 h-8 rounded-full shadow bg-purple p-2" @click="playEpisode(episode)">
                        <svg class="w-full h-full fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '../EventBus.js';

    export default {
        props: ['id'],

        data() {
            return {
                podcast: null,
                recentOnly: true,
            };
        },

        computed: {
            visibleEpisodes: function() {
                if (this.podcast.episodes.length > 5 && this.recentOnly) {
                    return this.podcast.episodes.slice(0,5);
                }

                return this.podcast.episodes;
            },
        },

        mounted() {
            axios.get(route('podcasts.show', this.id)).then(response => {
                this.podcast = response.data.data;
            });
        },

        methods: {
            subscribe() {
                if (this.podcast.subscribed) {
                    axios.delete(route('subscriptions.destroy', this.podcast.id)).then((response) => {
                        this.podcast.subscribed = false;
                    });
                } else {
                    axios.post(route('subscriptions.store'), {podcast_id:this.podcast.id}).then((response) => {
                        this.podcast.subscribed = true;
                    });
                }
            },

            playEpisode: EventBus.playEpisode,
        },
    }
</script>