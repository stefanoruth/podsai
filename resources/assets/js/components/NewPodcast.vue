<template>
    <modal @close="$emit('close')" :cssScope="'w-full md:w-2/5'">
        <div class="border-b">
            <input class="text-2xl text-black p-4 w-full" v-model="searchQuery" type="text" @keyup.enter="searchItunes" autofocus placeholder="Search for podcasts..." autocomplete="off">
        </div>
        
        <div v-show="searchResults.length > 0" class="flex flex-col mt-4 h-full overflow-y-scroll">
            <div v-for="(result, i) in searchResults" :key="i" class="px-4 mb-2 py-2 hover:bg-grey-lighter text-black flex justify-between overflow-hidden">
                <div>
                    <div class="mb-1">{{ result.collectionName }}</div>
                    <div class="text-sm text-grey-dark" :title="result.artistName">{{ result.artistName }}</div>
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
