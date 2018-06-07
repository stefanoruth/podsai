<template>
    <router-link :to="'/podcasts/'+podcast.id" class="flex no-underline cursor-pointer">
        <div>
            <img class="w-16 h-16 block shadow-md rounded-lg" :src="podcast.logo" :alt="podcast.title">
        </div>
        <div class="flex-1 px-2 flex flex-col justify-center">
            <div class="text-black mb-1">{{ podcast.title }}</div>
            <div class="text-grey-dark text-sm">
                <svg class="w-3 h-3 align-baseline fill-current text-grey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M16 8A6 6 0 1 0 4 8v11H2a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2V8a8 8 0 1 1 16 0v3a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2V8zm-4 2h3v10h-3V10zm-7 0h3v10H5V10z"/></svg>
                <span>{{ podcast.episodes_count }}</span>
            </div>
        </div>
    </router-link>     
</template>

<script>
    export default {
        props: ['podcast'],
    }
</script>

