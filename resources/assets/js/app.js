/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
window.Vue = Vue;

Vue.use(VueRouter);
Vue.config.productionTip = false
Vue.component('audio-player', require('./components/AudioPlayer'));
Vue.component('navbar', require('./components/Navbar'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: new VueRouter({
        routes: [
            {path:'/', component: require('./views/Home')},
            {path:'/episodes/latest', name:'episodes.latest', component: require('./views/LatestEpisodes')},
            {path:'/podcasts', name:'podcasts.index', component: require('./views/Podcasts')},
            {path:'/podcasts/:id', name:'podcasts.show', component: require('./views/PodcastShow'), props: true},
            {path:'/podcasts/:podcastId/episodes/:episodeId', name:'episodes.show', component: require('./views/EpisodeShow'), props: true},
            {path:'/new-podcast', name:'podcasts.create', component: require('./views/AddPodcast')},
        ],
    }),
});