<template>
    <div class="search">
        <input v-model="searchQuery" type="text" v-on:keyup.enter="search" placeholder="Search for podcasts..." autocomplete="off">
        <div class="results" v-show="results.length > 0">
            <template v-for="result in results">
                <router-link :to="{name:'podcastShow',params:{id:result.objectID}}">
                    <div @click="clearInput" style="margin-bottom:10px;">
                        <strong v-html="result._highlightResult.title.value"></strong>
                        <br>
                        <span v-html="result._highlightResult.description.value"></span>
                    </div>
                </router-link>
            </template>
            <div>
                <a href="https://www.algolia.com/">
                    <img :src="algoliaImage" alt="Search by Algolia" width="105">
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    var algoliasearch = require('algoliasearch');

    export default {
        data() {
            return {
                searchQuery: null,
                results: [],
                algolia: null,
            };
        },

        computed: {
            algoliaImage: function(){
                return baseUrl+'assets/search-by-algolia.svg';
            },
        },

        created() {
            this.algolia = algoliasearch('I1D6UBRELN', '77fc9a5cb6b106f6a8ce0235aac5522e').initIndex('podcasts');
        },

        methods: {
            clearInput() {
                this.searchQuery = null;
                this.results = [];
            },

            searchItunes() {
                axios.get('https://itunes.apple.com/search', {
                    params: {
                        media: 'podcast',
                        limit: 5,
                        term: this.searchQuery,
                    },
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).then(function(response){
                    console.log(response.data, response);
                }).catch(function(response){
                    console.log(response);
                });
            },

            search() {
                this.algolia.search({query: this.searchQuery}, (err, content) => {
                    console.log(content);
                    this.results = content.hits;
                });
            }
        }
    }
</script>

<style scoped>
    .search {
        width: 500px;
        position: relative;
    }

    input {
        width: 100%;
    }

    .results {
        position: absolute;
        top: 100%;
        left: 0px;
        right: auto;
        z-index: 200;
        background-color: #fff;
        border: 1px solid #000;
    }
</style>