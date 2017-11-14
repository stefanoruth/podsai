<template>
    <div class="max-w-md w-full lg:flex shadow rounded bg-white">
        <div class="h-32 w-32 flex-none bg-cover overflow-hidden" v-bind:style="{'background-image':'url('+episode.podcast.logo+')'}"></div>
        <div class="p-4 flex flex-col">
            <div class="text-xs text-grey-darker" v-if="episode.number != null">
                <span v-if="episode.season > 1">Season: {{ episode.season }} -</span>
                <span>Episode: {{ episode.number }}</span>
            </div>
            <div class="mb-2">
                <span class="text-black font-bold text-l">{{ episode.title }}</span>
                <span class="text-xs font-bold text-grey-darker">@{{ episode.podcast.title }}</span>
            </div>
            
            <div class="text-grey-darker text-sm">{{ episode.description_short }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['episode'],
    }
</script>