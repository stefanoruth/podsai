<template>
    <div class="h-full overflow-y-scroll">
        <div class="max-w-md mx-auto px-4 md:px-0 py-6">
            <div class="text-2xl mb-4">Playlist</div>
            <div v-for="episode in episodes" :key="episode.id" class="flex p-3 bg-white shadow rounded-lg mb-4">
                <router-link :to="'/podcasts/'+episode.podcast.id+'/episodes/'+episode.id" >
                    <img class="w-16 h-16 block shadow-md rounded-lg" :src="episode.podcast.logo" :alt="episode.title">
                </router-link>
                <div class="flex-1 px-2 flex flex-col justify-center">
                    <router-link :to="'/podcasts/'+episode.podcast.id+'/episodes/'+episode.id" class="no-underline text-black">{{ episode.title }}</router-link>
                    <router-link :to="'/podcasts/'+episode.podcast.id" class="no-underline text-grey">{{ episode.podcast.title }}</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
    }
</script>
