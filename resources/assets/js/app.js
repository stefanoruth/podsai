/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
window.Vue = Vue;
window.mixVersion = '';

Vue.use(VueRouter);
Vue.config.productionTip = false
Vue.component('audio-player', require('./components/AudioPlayer'));
Vue.component('navbar', require('./components/Navbar'));
Vue.component('modal', require('./components/Modal'));
Vue.component('episode-image', require('./components/EpisodeImage'));
Vue.component('podcast-image', require('./components/PodcastImage'));
Vue.component('podcast-list-item', require('./components/PodcastListItem'));
Vue.component('episode-info', require('./components/EpisodeInfo'));

Vue.mixin({
    methods: {
        subscribe(podcast) {
            if (podcast.subscribed) {
                axios.delete(route('subscriptions.destroy', podcast.id)).then((response) => {
                    podcast.subscribed = false;
                });
            } else {
                axios.post(route('subscriptions.store'), {podcast_id:podcast.id}).then((response) => {
                    podcast.subscribed = true;
                });
            }
        },
    },
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if(document.getElementById('app')) {
    const app = new Vue({
        el: '#app',
        router: new VueRouter({
            routes: require('./routes.js'),
        }),

        mounted() {

            axios.get('mix-manifest.json').then(res => {
                var version = res.data['/app.css'].split('?');

                if (version.length == 2) {
                    window.mixVersion = '?'+version.pop();
                }
            });
        }
    });
}

