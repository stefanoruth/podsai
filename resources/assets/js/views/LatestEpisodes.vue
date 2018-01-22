<template>
    <div class="mx-auto max-w-lg py-8 px-4">
        <div class="mb-4">
            <div class="text-3xl">Latest Episodes</div>
        </div>
        <div>
            <div v-for="episode in episodes" :key="episode.id" class="flex mb-4">
                <div class="w-1/4 pr-4">
                    <img :src="episode.podcast.logo">
                </div>
                <div class="w-3/4 flex flex-col justify-center">
                    <div class="text-sm text-grey-dark mb-1">{{ episode.published_at }}</div>
                    <div class="mb-1">
                        <router-link class="block truncate no-underline text-black font-bold text-xl" :to="{name:'episodes.show', params:{id:episode.id}}">{{ episode.title }}</router-link>
                    </div>
                    <div class="mb-4">
                        <router-link class="no-underline uppercase text-sm text-grey-dark" :to="{name:'podcasts.show', params:{id:episode.podcast.id}}">{{ episode.podcast.title }}</router-link>
                    </div>
                    <div>
                        <button class="btn" @click="playEpisode(episode)">Listen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '../EventBus.js';

    export default {
        data() {
            return {
                episodes: [],
            };
        },

        mounted() {
            axios.get(route('latest.index')).then(res => {
                this.episodes = res.data.data;
            });
        },

        methods: {
            playEpisode: EventBus.playEpisode,
        },
    }
</script>
