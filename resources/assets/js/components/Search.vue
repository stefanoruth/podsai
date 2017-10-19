<template>
    <div class="search">
        <input v-model="searchQuery" type="text" v-on:keyup.enter="search" placeholder="Search for podcasts..." autocomplete="off">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchQuery: null,
            };
        },

        methods: {
            search() {
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
            }
        }
    }
</script>