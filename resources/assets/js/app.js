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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if(document.getElementById('app')) {
    const app = new Vue({
        el: '#app',
        router: new VueRouter({
            routes: [
                { path: '/', component: require('./views/Home') },
                { path: '/episodes/latest', name: 'episodes.latest', component: require('./views/LatestEpisodes') },
                { path: '/podcasts', name: 'podcasts.index', component: require('./views/Podcasts') },
                { path: '/podcasts/:id', name: 'podcasts.show', component: require('./views/PodcastShow'), props: true },
                { path: '/podcasts/:podcastId/episodes/:episodeId', name: 'episodes.show', component: require('./views/EpisodeShow'), props: true },
                { path: '/profile', name: 'profile', component: require('./views/Profile') },
            ],
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

