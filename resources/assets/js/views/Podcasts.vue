<template>
    <div>
        <div class="p-4 max-w-2xl mx-auto">
            <div class="flex justify-between mb-4">
                <div class="text-3xl mb-2 mr-4">All Podcasts</div>
                <button class="btn-primary" @click="modal = true">Find a new Podcast</button>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div v-for="podcast in podcasts" :key="podcast.id" class="p-4 w-1/2 sm:w-1/4 md:w-1/6">
                    <router-link :to="{name:'podcasts.show', params:{id:podcast.id}}" class="mb-2 block">
                        <podcast-image :podcast="podcast"></podcast-image>
                    </router-link>
                    <router-link :to="{name:'podcasts.show', params:{id:podcast.id}}" class="block mb-1 no-underline font-bold truncate text-sm text-black">{{ podcast.title }}</router-link>
                    <a :href="podcast.domain_url" target="_blank" rel="noopener" class="block no-underline uppercase truncate text-xs text-grey-darker">{{ podcast.domain }}</a>
                </div>
            </div>
        </div>

       <new-podcast v-if="modal" @close="modal = false"></new-podcast>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                podcasts: [],
                modal: false,
            };
        },

        created() {
            axios.get(route('podcasts.index')).then((response) => {
                this.podcasts = response.data.data;
            });
        },

        components: {
            'new-podcast': require('../components/NewPodcast'),
        },
    }
</script>