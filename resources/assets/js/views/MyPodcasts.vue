<template>
    <div class="flex flex-col h-full">
        <div class="bg-white border-b">
            <div class="flex mx-auto max-w-md">
                <div class="flex-1">
                    <router-link to="/my-podcasts" class="no-underline text-black text-center block p-2 text-xl hover:bg-grey-light border-b border-black">Podcasts</router-link>
                </div>
                <div class="flex-1">
                    <router-link to="/my-podcasts/episodes" class="no-underline text-black text-center block p-2 text-xl hover:bg-grey-light border-b border-transparent">Episodes<span class="text-xs text-purple align-top font-medium">34</span></router-link>
                </div>
            </div>
        </div>
        <div class="flex-1 overflow-y-scroll">
            <div class="max-w-md mx-auto px-4 md:px-0 py-6">
                <div v-for="podcast in podcasts" :key="podcast.id" class="flex p-3 shadow rounded-lg bg-white mb-4">
                    <podcast-list-item class="flex-1" :podcast="podcast"></podcast-list-item>
                    <div class="flex items-center">
                        <button @click="subscribe(podcast)" class="w-10 h-10 cursor-pointer">
                            <svg v-if="podcast.subscribed"class="w-6 h-6 fill-current text-grey-darker" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"/></svg>
                            <svg v-else class="w-6 h-6 fill-current text-grey-darker" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/></svg>
                        </button>
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
                podcasts: [],
            };
        },

        mounted() {
            axios.get(route('subscriptions.index')).then(res => {
                this.podcasts = res.data.data;
            });
        },
    }
</script>
