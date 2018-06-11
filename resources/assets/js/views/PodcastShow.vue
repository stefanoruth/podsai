<template>
    <div v-if="podcast != null" class="mx-auto max-w-md overflow-y-scroll relative h-full">
        <div class="w-full fixed pin-t max-w-md">
            <div class="">
                <img class="w-full block" :src="podcast.logo" :alt="podcast.title">
                <div class="absolute pin bg-black" style="opacity: 0.45"></div>
            </div>
            <div class="text-white text-center absolute pin-t w-full px-4 pt-8">
                <div class="text-2xl mb-2">{{ podcast.title }}</div>
                <div class="mb-4">
                    <svg class="w-3 h-3 align-baseline fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M16 8A6 6 0 1 0 4 8v11H2a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2V8a8 8 0 1 1 16 0v3a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2V8zm-4 2h3v10h-3V10zm-7 0h3v10H5V10z"/></svg>
                    <span>{{ podcast.episodes_count }}</span>
                </div>
                <div class="mb-4">
                    <button @click="subscribe" class="border border-white text-white px-2 py-1 rounded-lg">
                        <span v-show="podcast.subscribed">Subscribed</span>
                        <span v-show="!podcast.subscribed">Subscribe</span>
                    </button>
                </div>
                <div class="max-w-sm mx-auto">{{ podcast.description }}</div>
            </div>
        </div>

        <div class="pt-24">
            <div class="bg-white shadow relative rounded-lg mx-4 mb-8">
                <div v-for="episode in podcast.episodes" :key="episode.id" class="flex border-b p-4">
                    <router-link :to="'/podcasts/'+podcast.id+'/episodes/'+episode.id" class="flex-1 pr-2 no-underline text-black">
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
                    </router-link>
                    <div class="flex items-center">
                        <button class="w-8 h-8 rounded-full shadow bg-purple p-2" @click="playEpisode(episode)">
                            <svg class="w-full h-full fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </button>
                    </div>
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