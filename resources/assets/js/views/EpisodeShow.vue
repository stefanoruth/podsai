<template>
    <div class="columns">
        <div class="column" v-if="episode != null">
            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <div class="image is-128x128">
                            <img :src="episode.podcast.logo">
                        </div>
                    </div>
                    <div class="media-content">
                        <div class="title">{{ episode.title }}</div>
                        <div class="content"><small>{{ episode.length }}</small></div>
                        <div class="content" v-if="episode.show_notes != null" v-html="episode.show_notes"></div>
                        <div class="content" v-else v-html="episode.description"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'number'],

        data() {
            return {
                episode: null,
            };
        },

        watch: {
            number: function(newVal) {
                this.init(newVal);
            }
        },

        created() {
            this.init(this.number);
        },

        methods: {
            init(id) {
                axios.get(route('episodes.show', id)).then((response) => {
                    this.episode = response.data.data;
                });
            }
        }
    }
</script>