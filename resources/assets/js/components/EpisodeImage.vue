<template>
    <div class="relative">
        <img class="block w-32 md:w-full shadow-md" :src="episode.podcast.logo" :alt="episode.title">
        <div v-show="episode.completion !== null && episode.completion.completed" class="absolute pin flex justify-center items-center p-4">
            <div class="bg-orange opacity-75 absolute pin"></div>
            <svg class="fill-current text-white z-10 h-24 w-24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['episode'],
    }
</script>
