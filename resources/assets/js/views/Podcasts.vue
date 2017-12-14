<template>
    <div class="p-4 max-w-md mx-auto">
        <div class="mb-8">
            <div class="text-xl">Search</div>
            <div class="p-3">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" v-model="searchQuery" type="text" @keyup="search" placeholder="Search for podcasts..." autocomplete="off">
                <div class="rounded overflow-hidden shadow-lg bg-white flex flex-col mt-4 pt-2" v-show="searchResults.length > 0">
                    <div class="mb-2">
                        <router-link class="no-underline text-black" v-for="result in searchResults" :key="result.objectID" :to="{name:'podcasts.show',params:{id:result.objectID}}">
                            <div class="p-2 mb-1 hover:bg-grey-lighter" v-html="result._highlightResult.title.value"></div>
                        </router-link>
                    </div>
                    <div class="flex justify-end">
                        <a href="https://www.algolia.com/">
                            <img :src="algoliaImage" alt="Search by Algolia" class="p-2 w-32">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-8">
            <div class="text-xl">Subscribed</div>
            <div class="flex flex-wrap">
                <div v-for="podcast in subscribedPodcasts" :key="podcast.id" class="p-3">
                    <div class="bg-grey cursor-pointer shadow-md" :title="podcast.title" @click="$router.push({name:'podcasts.show', params:{id:podcast.id}})">
                        <div class="h-32 w-32 flex-none bg-cover overflow-hidden" v-bind:style="{'background-image':'url('+podcast.logo+')'}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="text-xl">Podcasts</div>
            <div class="flex flex-wrap">
                <div v-for="podcast in notSubscribedPodcats" :key="podcast.id" class="p-3">
                    <div class="bg-grey cursor-pointer shadow-md" :title="podcast.title" @click="$router.push({name:'podcasts.show', params:{id:podcast.id}})">
                        <div class="h-32 w-32 flex-none bg-cover overflow-hidden" v-bind:style="{'background-image':'url('+podcast.logo+')'}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
    var algoliasearch = require('algoliasearch');

    export default {
        data() {
            return {
                podcasts: [],
                searchQuery: null,
                searchResults: [],
                algolia: null,
            };
        },

        computed: {
            subscribedPodcasts: function() {
                return _.filter(this.podcasts, (item) => {return item.subscribed;});
            },

            notSubscribedPodcats: function() {
                return _.filter(this.podcasts, (item) => {return !item.subscribed;});
            },
            
            algoliaImage: function(){
                return baseUrl+'assets/search-by-algolia.svg';
            },
        },

        mounted() {
            this.algolia = algoliasearch('I1D6UBRELN', '77fc9a5cb6b106f6a8ce0235aac5522e').initIndex('podcasts');

            axios.get(route('podcasts.index')).then(response => {
                this.podcasts = response.data.data;
            });
        },

        methods: {
            clearInput() {
                this.searchQuery = null;
                this.searchResults = [];
            },

            search() {
                this.algolia.search({query: this.searchQuery}, (err, content) => {
                    console.log(content);
                    this.searchResults = content.hits;
                });
            }
        },
    }
</script>