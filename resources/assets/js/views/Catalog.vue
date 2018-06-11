<template>
    <div class="">
        <div class="px-4 pt-4 mb-4 mx-auto max-w-md">
            <search></search>
        </div>

        <div class="mb-4 max-w-md mx-auto">
            <div class="px-4">
                <div class="border-b mb-4 text-xl pb-2">Best Podcasts</div>
            </div>
            <div class="px-4">
                <podcast-list-item class="mb-4" v-for="podcast in mostSubscribedPodcasts" :key="podcast.id" :podcast="podcast"></podcast-list-item>
            </div>
        </div>

        <div class="mb-6 max-w-md mx-auto">
            <div class="px-4">
                <div class="border-b mb-4 text-xl pb-2">Podcasts</div>
            </div>
            <div class="flex flex-wrap">
                <div v-for="podcast in allPodcasts" :key="podcast.id" class="px-4 py-2 w-1/3">
                    <div>
                        <img class="w-full block rounded-lg shadow" :src="podcast.logo" :alt="podcast.title">
                    </div>
                    <div class="truncate">{{ podcast.title }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                mostSubscribedPodcasts: [],
                allPodcasts: [],
            };
        },

        mounted() {
            axios.get(route('top.index')).then(res => {
                this.mostSubscribedPodcasts = res.data.data;
            });

            axios.get(route('podcasts.index')).then(res => {
                this.allPodcasts = res.data.data;
            });
        }
    }
</script>

