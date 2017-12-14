<template>
    <div class="max-w-md w-full flex shadow rounded bg-white">
        <div class="h-32 w-32 flex-none bg-cover overflow-hidden cursor-pointer" @click="$router.push({name:'episodes.show',params:{id:episode.id}})" v-bind:style="{'background-image':'url('+episode.podcast.logo+')'}"></div>
        <div class="p-4 flex flex-col justify-between">
            <div class="flex">
                <div class="flex-1">
                    <div class="text-xs text-grey-darker" v-if="episode.number != null">
                        <span v-if="episode.season > 1">Season: {{ episode.season }} -</span>
                        <span>Episode: {{ episode.number }}</span>
                    </div>
                    <div class="cursor-pointer" @click="$router.push({name:'episodes.show',params:{id:episode.id}})">
                        <span class="text-black font-bold">{{ episode.title }}</span>
                        <span class="text-xs font-bold text-grey-darker">@{{ episode.podcast.title }}</span>
                    </div>
                </div>
                <div class="ml-2">
                    <button @click="playEpisode(episode)" class="bg-grey hover:bg-grey-dark text-white font-bold py-1 px-2 rounded">Play</button>
                </div>
            </div>
            
            <div class="text-grey-darker text-sm">{{ episode.description_short }}</div>
            <div class="text-grey-darker text-sm">Status: <span>{{ episode.completion != null && episode.completion.completed ? 'Completed' : 'New' }}</span></div>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '../EventBus.js';

    export default {
        props: ['episode'],

        methods: {
            playEpisode: EventBus.playEpisode,
        },
    }
</script>