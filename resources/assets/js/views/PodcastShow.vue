<template>
    <div v-if="podcast != null" class="mx-auto max-w-2xl px-4 py-8">
        <div class="md:flex">
            <div class="flex justify-center md:block md:pr-8 md:w-1/4 mb-4">
                <img class="h-32 w-32 md:h-auto md:w-full shadow-md" :src="podcast.logo">
            </div>
            <div class="flex-1">
                <div class="mb-8">
                    <div class="text-3xl text-black font-bold">{{ podcast.title }}</div>
                    <div class="mb-2">
                        <a class="no-underline uppercase text-grey-darker text-sm" :href="podcast.domain_url" target="_blank">{{ podcast.domain }}</a>
                    </div>
                    <div class="mb-4">
                        <button class="py-1 px-3 border rounded" :class="{'bg-orange text-white border-orange': podcast.subscribed, 'hover:bg-orange hover:text-white hover:border-orange': !podcast.subscribed}" @click="subscribe">{{ podcast.subscribed ? 'Subscribed' : 'Subscribe' }}</button>
                    </div>
                    <div class="text-grey">{{ podcast.description }}</div>
                </div>

                <div class="pb-8">
                    <div class="border-b pb-2">
                        <template v-if="recentOnly">
                            <span class="font-bold mr-2">Recent Episodes</span>
                            <a class="no-underline text-blue hover:text-blue-darker hover:underline" v-if="recentOnly" @click="recentOnly = false" href="#">View all</a>
                        </template>
                        <span v-else class="font-bold">All episodes</span>
                    </div>
                    <div v-for="episode in visibleEpisodes" :key="episode.id" class="flex border-b items-center py-2">
                        <div class="text-grey-dark px-3" v-if="episode.number">{{ episode.number }}</div>
                        <div class="pr-2 flex-1">
                            <router-link :to="{name:'episodes.show', params:{podcastId: podcast.id, episodeId: episode.id}}">{{ episode.title }}</router-link>
                        </div>
                        <div class="pr-2 text-grey-dark">45 min</div>
                        <div class="pr-4 text-grey-dark">{{ episode.published_at }}</div>
                        <div>
                            <button class="btn" @click="playEpisode(episode)">Listen</button>
                        </div>
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
                if (this.recentOnly) {
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