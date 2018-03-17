<template>
    <div>
        <div class="bg-orange px-8 py-8 md:py-12 border-b border-t">
            <div class="max-w-2xl mx-auto">
                <div class="text-3xl text-white font-bold">Podcasting for everyone</div>
                <div class="text-xl text-white">A great place to discover and listen to podcasts.</div>
            </div>
        </div>

        <div class="p-4 max-w-2xl mx-auto">
            <div class="text-3xl mb-2">Popular Shows</div>
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                podcasts: [],
            };
        },

        created() {
            axios.get(route('top.index')).then((response) => {
                this.podcasts = response.data.data;
            });
        },
    }
</script>