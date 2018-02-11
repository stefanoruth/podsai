<template>
    <div class="relative">
        <img class="w-full block shadow-md" :src="podcast.logo" :alt="podcast.title">
        <div v-if="podcast.subscribed" class="badge select-none">
            <span>Subscribed</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['podcast'],
    }
</script>
