<template>
    <div v-if="podcast != null" class="columns">
        <div class="column">
            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <div class="image is-128x128">
                            <img :src="podcast.logo">
                        </div>
                    </div>
                    <div class="media-content">
                        <div class="title">{{ podcast.title }}</div>
                        <div class="content">{{ podcast.description }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column is-5">
            <template v-for="episode in podcast.episodes">
                <router-link :to="{name:'episodeShow', params:{id:podcast.id, number:episode.id}}" class="box">
                    <div class="content">
                        <p>
                            <span v-if="episode.number != null">
                                <small><span v-if="episode.season > 1">Season: {{ episode.season }} -</span> Episode: {{ episode.number }}</small>
                                <br>
                            </span>
                            <strong>{{ episode.title }}</strong>
                            <br>
                            <span>{{ episode.description_short }}</span>
                        </p>
                    </div>
                </router-link>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],

        data() {
            return {
                podcast: null,
            };
        },

        watch: { 
            id: function(newVal) {
                this.init(newVal);
            }
        },

        created() {
            this.init(this.id);
        },

        methods: {
            init(id) {
                axios.get(route('podcasts.show', id)).then((response) => {
                    this.podcast = response.data.data;
                });
            }
        }
    }
</script>