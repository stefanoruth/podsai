<template>
    <div class="flex flex-wrap p-4 max-w-md mx-auto">
        <div v-for="podcast in podcasts" :key="podcast.id" class="p-3">
            <div class="bg-grey cursor-pointer shadow-md" :title="podcast.title" @click="$router.push({name:'podcasts.show', params:{id:podcast.id}})">
                <div class="h-32 w-32 flex-none bg-cover overflow-hidden" v-bind:style="{'background-image':'url('+podcast.logo+')'}"></div>
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
            axios.get(route('podcasts.index')).then(response => {
                this.podcasts = response.data.data;
            });
        },
    }
</script>
