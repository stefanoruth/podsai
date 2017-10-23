<template>
    <div>
        <div class="columns">
            <div class="column">
                <div class="grid">
                    <template v-for="(podcast, key) in trendingPodcasts">
                        <article v-if="key == 0" class="box is-marginless is-paddingless" style="grid-row: 1 / 3;grid-column: 2 / 4;">
                            <router-link :to="{name:'podcastShow',params:{id:podcast.id}}">
                                <div class="image is-square">
                                    <img :src="podcast.logo">
                                </div>
                            </router-link>
                        </article>
                        <article v-else-if="key == 1" class="box is-marginless is-paddingless" style="grid-row: 2 / 4;grid-column: 5 / 7;">
                            <router-link :to="{name:'podcastShow',params:{id:podcast.id}}">
                                <div class="image is-square">
                                    <img :src="podcast.logo">
                                </div>
                            </router-link>
                        </article>
                        <article v-else class="box is-marginless is-paddingless">
                            <router-link :to="{name:'podcastShow',params:{id:podcast.id}}">
                                <div class="image is-square">
                                    <img :src="podcast.logo">
                                </div>
                            </router-link>
                        </article>
                    </template>
                </div>
            </div>
            <div class="column is-5">
                <div v-for="episode in latestEpisodes" @click="playEpisode(episode)" class="box">
                    <article class="media">
                        <div class="media-left">
                            <div class="image is-48x48">
                                <img :src="episode.podcast.logo">
                            </div>
                        </div>
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <span v-if="episode.number != null">
                                        <small><span v-if="episode.season > 1">Season: {{ episode.season }} -</span> Episode: {{ episode.number }}</small>
                                        <br>
                                    </span>
                                    <strong>{{ episode.title }}</strong> <small>@{{ episode.podcast.title }}</small>
                                    <br>
                                    <span>{{ episode.description_short }}</span>
                                </p>
                            </div>
                        </div>
                    </article>
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
                latestEpisodes: [],
                trendingPodcasts: [],
            };
        },

        created() {
            axios.get(route('latest.index')).then((response) => {
                this.latestEpisodes = response.data.data;
            });

            axios.get(route('trending.index')).then((response) => {
                this.trendingPodcasts = response.data.data;
            });
        },

        methods: {
            playEpisode: EventBus.playEpisode,
        },
    }
</script>