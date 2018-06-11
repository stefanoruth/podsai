<template>
    <div class="">
        <div class="px-4 pt-4 mb-4 mx-auto max-w-md">
            <search></search>
        </div>

        <div class="flex max-w-md mx-auto overflow-y-scroll">
            <div class="px-4" style="flex: 0 0 100%;">
                <div class="border-b mb-4 text-xl pb-2">Best Podcasts</div>
                <div>
                    <podcast-list-item class="mb-4" v-for="podcast in podcasts" :key="podcast.id" :podcast="podcast"></podcast-list-item>
                </div>
            </div>
            <div class="px-4" style="flex: 0 0 100%;">
                <div class="border-b mb-4 text-xl pb-2">Most Liked</div>
                <div>
                    <podcast-list-item class="mb-4" v-for="podcast in podcasts" :key="podcast.id" :podcast="podcast"></podcast-list-item>
                </div>
            </div>
            <div class="px-4" style="flex: 0 0 100%;">
                <div class="border-b mb-4 text-xl pb-2">Top Ratings</div>
                <div>
                    <podcast-list-item class="mb-4" v-for="podcast in podcasts" :key="podcast.id" :podcast="podcast"></podcast-list-item>
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
            axios.get(route('top.index')).then((response) => {
                this.podcasts = response.data.data;
            });
        }
    }
</script>

