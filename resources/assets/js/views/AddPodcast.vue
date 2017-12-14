<template>
    <div class="max-w-md p-4 mx-auto">
        <div class="fixed pin bg-grey-dark opacity-75 hidden justify-center items-center text-xl" :class="{'flex': loading}">Loading...</div>
        <div class="text-xl">Add Podcast</div>
        <div class="p-3">
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" v-model="searchQuery" type="text" v-on:keyup="searchItunes" placeholder="Search for podcasts..." autocomplete="off">
            <div class="rounded overflow-hidden shadow-lg bg-white flex flex-col mt-4">
                <div v-for="(result, i) in searchResults" :key="i">
                    <div class="p-2 mb-1 hover:bg-grey-lighter text-black flex justify-between">
                        <div>
                            <div class="mb-1">{{ result.collectionName }}</div>
                            <div class="text-sm text-grey-dark">{{ result.artistName }}</div>
                        </div>
                        <div class="flex items-center">
                            <button class="bg-grey hover:bg-grey-dark text-white font-bold py-1 px-2 rounded flex-no-grow" @click="addPodcast(result.feedUrl)">Add</button>
                        </div>
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
                searchQuery: null,
                searchResults: [],
                loading: false,
            };
        },

        methods: {
            searchItunes() {
                axios.get('https://itunes.apple.com/search', {
                    params: {
                        media: 'podcast',
                        limit: 10,
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
                });
            }
        }
    }
</script>
