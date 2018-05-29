<template>
    <modal @close="$emit('close')" :cssScope="'w-full md:max-w-3/5'" :loading="loading">
        <div class="border-b">
            <input class="text-2xl text-black p-4 w-full" v-model="searchQuery" type="text" @keyup.enter="searchItunes" autofocus placeholder="Search for podcasts..." autocomplete="off">
        </div>
        
        <div v-show="searchResults.length > 0" class="flex flex-col mt-4 h-full overflow-y-scroll">
            <div v-for="(result, i) in searchResults" :key="i" class="px-4 mb-2 py-2 hover:bg-grey-lighter text-black flex justify-between overflow-hidden max-w-100">
                <div class="flex items-center pr-2">
                    <img class="block w-10 h-10" :src="result.artworkUrl30" :alt="result.collectionName">
                </div>
                <div class="flex-1 pr-2" :title="result.feedUrl">
                    <div class="mb-1">{{ result.collectionName }}</div>
                    <div class="text-sm text-grey-dark">{{  result.artistName }}</div>
                </div>
                <div class="flex items-center">
                    <button class="btn" @click="addPodcast(result.feedUrl)">Add</button>
                </div>
            </div>
        </div>
    </modal>
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
                        name: 'podcasts.show',
                        params: {
                            id: response.data.data.id,
                        },
                    });
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response;
                });
            }
        }
    }
</script>
