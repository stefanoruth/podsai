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
Vue.component('audio-player', require('./AudioPlayer'));
Vue.component('search-field', require('./Search'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: new VueRouter({
        routes: [
            {path:'/', component: require('./Home')},
            {path:'/podcasts', component: require('./PodcastList')},
        ],
    }),

    data: {
        episode: null,
    },

    methods: {
        playEpisode(id) {
            this.episode = id;
        }
    },
});
