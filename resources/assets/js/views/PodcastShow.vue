<template>
    <div v-if="podcast != null" class="mx-auto max-w-2xl md:px-4 py-8">
        <div class="md:flex">
            <div class="flex justify-center md:block md:pr-8 md:w-1/4 mb-4">
                <podcast-image :podcast="podcast" class="h-32 w-32 md:h-auto md:w-full"></podcast-image>
            </div>
            <div class="flex-1">
                <div class="mb-8 text-center md:text-left bg-white p-4 shadow">
                    <div class="text-3xl text-black font-bold">{{ podcast.title }}</div>
                    <div class="mb-3">
                        <a class="no-underline uppercase text-grey-darker text-sm" :href="podcast.domain_url" rel="noopener" target="_blank">{{ podcast.domain }}</a>
                    </div>
                    <div class="mb-4">
                        <button class="py-1 px-3 border rounded" :class="{'bg-orange text-white border-orange': podcast.subscribed, 'hover:bg-orange hover:text-white hover:border-orange': !podcast.subscribed}" @click="subscribe">{{ podcast.subscribed ? 'Subscribed' : 'Subscribe' }}</button>
                    </div>
                    <div class="">{{ podcast.description }}</div>
                </div>

                <div class="bg-white shadow">
                    <div class="p-4 flex justify-between">
                        <template v-if="recentOnly">
                            <span class="font-bold mr-2">Recent Episodes</span>
                            <button class="no-underline text-orange hover:text-orange-dark hover:underline" v-if="recentOnly" @click="recentOnly = false">View all</button>
                        </template>
                        <span v-else class="font-bold">All episodes</span>
                    </div>
                    <div v-for="episode in visibleEpisodes" :key="episode.id" class="flex border-t items-center py-2 px-4 hover:bg-grey-lighter">
                        <div class="text-grey-dark mr-4" v-if="episode.number">{{ episode.number }}</div>
                        <div class="flex-1 md:flex items-center">
                            <div class="flex-1 mb-1 mr-2 md:mb-0">
                                <router-link class="block" :class="{'line-through text-grey-darker': episode.completion != null && episode.completion.completed, 'no-underline text-black': episode.completion == null || episode.completion.completed == false}" :to="{name:'episodes.show', params:{podcastId: podcast.id, episodeId: episode.id}}">{{ episode.title }}</router-link>
                            </div>
                            <div class="flex">
                                <div class="mr-2 text-grey-dark text-right">{{ episode.length }}</div>
                                <div class="text-grey-dark text-right w-24">{{ episode.published_at }}</div>
                            </div>
                        </div>
                        <div class="ml-4">
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