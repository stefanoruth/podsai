<template>
    <div class="relative">
        <input class="p-2 border rounded-lg w-full" v-model="searchQuery" @keyup.enter="searchItunes" type="text" placeholder="Search..." autocomplete="off">
        
        <div class="absolute bg-white w-full border shadow mt-1 rounded-lg" v-show="searchResults.length > 0">
            <div v-for="(result, i) in searchResults" :key="i" class="px-4 mb-2 py-2 hover:bg-grey-lighter text-black flex justify-between overflow-hidden max-w-100">
                <div class="flex items-center pr-2">
                    <img class="block w-10 h-10" :src="result.artworkUrl30" :alt="result.collectionName">
                </div>
                <div class="flex-1 pr-2" :title="result.feedUrl">
                    <div class="mb-1">{{ result.collectionName }}</div>
                    <div class="text-sm text-grey-dark">{{  result.artistName }}</div>
                </div>
                <div class="flex items-center">
                    <button class="hover:bg-purple p-2 rounded-full group inline-flex" @click="addPodcast(result.feedUrl)">
                        <svg class="w-6 h-6 fill-current text-grey-darker group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 6z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchQuery: null,
                searchResults: [],
                loading: false,
                error: null,
            };
        },

        methods: {
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
                }).then(response => {
                    this.searchResults = response.data.results;
                });
            },

            addPodcast(url) {
                this.loading = true;
                axios.post(route('podcasts.store'), {url:url}).then(response => {
                    this.$router.push({
                        path: '/podcasts/'+response.data.data.id,
                    });
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response;
                });
            }
        }
    }
</script>
