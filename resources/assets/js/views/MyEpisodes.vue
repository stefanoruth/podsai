<template>
    <div class="flex flex-col h-full">
        <div class="bg-white border-b">
            <div class="flex mx-auto max-w-md">
                <div class="flex-1">
                    <router-link to="/my-podcasts" class="no-underline text-black text-center block p-2 text-xl hover:bg-grey-light border-b border-transparent">Podcasts</router-link>
                </div>
                <div class="flex-1">
                    <router-link to="/my-podcasts/episodes" class="no-underline text-black text-center block p-2 text-xl hover:bg-grey-light border-b border-black">Episodes<span class="text-xs text-purple align-top font-medium">34</span></router-link>
                </div>
            </div>
        </div>
        <div class="flex-1 overflow-y-scroll">
            <div class="max-w-md mx-auto px-4 md:px-0 py-6">
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
