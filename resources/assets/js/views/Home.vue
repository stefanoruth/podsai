<template>
    <div class="max-w-md p-4 mx-auto">
        <episode-card v-for="episode in latestEpisodes" :key="episode.id" :episode="episode" class="mb-4"></episode-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                latestEpisodes: [],
            };
        },

        created() {
            axios.get(route('latest.index')).then((response) => {
                this.latestEpisodes = response.data.data;
            });
        },
    }
</script>