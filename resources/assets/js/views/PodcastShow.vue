<template>
    <div v-if="podcast != null" class="mx-auto max-w-md p-4">
        <div class="w-full shadow rounded bg-white mb-8">
            <div class="flex">
                <div class="h-32 w-32 flex-none bg-cover overflow-hidden" v-bind:style="{'background-image':'url('+podcast.logo+')'}"></div>
                <div class="p-4">
                    <div class="text-lg font-bold mb-2">{{ podcast.title }}</div>
                    <div>
                        <button class="bg-grey hover:bg-grey-dark text-white font-bold py-1 px-2 rounded" @click="subscribe">{{ podcast.subscribed ? 'Unsubscribe' : 'Subscribe' }}</button>
                        <button class="bg-grey hover:bg-grey-dark text-white font-bold py-1 px-2 rounded">Play</button>
                    </div>
                </div>
            </div>
            <div class="p-4">{{ podcast.description }}</div>
        </div>

        <div v-for="episode in podcast.episodes" :key="episode.id" class="flex w-full shadow rounded bg-white mb-4 p-4">
            <div class="flex-1 cursor-pointer" @click="$router.push({name:'episodes.show',params:{id:episode.id}})">
                <div class="text-xs text-grey-darker" v-if="episode.number != null">
                    <span v-if="episode.season > 1">Season: {{ episode.season }} -</span>
                    <span>Episode: {{ episode.number }}</span>
                </div>
                <div class="text-black font-bold">{{ episode.title }}</div>
            </div>
            <div>
                <button @click="playEpisode(episode)" class="bg-grey hover:bg-grey-dark text-white font-bold py-1 px-2 rounded">Play</button>
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
            };
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