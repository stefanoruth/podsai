<template>
    <nav class="relative select-none bg-indigo lg:flex lg:items-stretch">
        <div class="flex flex-no-shrink items-stretch min-h-3">
            <router-link to="/" class="flex-no-grow flex-no-shrink relative py-2 px-4 leading-normal text-white no-underline flex items-center">Podsai</router-link>
            <button class="block lg:hidden cursor-pointer ml-auto relative w-12 h-12 menu-burger" v-on:click="mobileMenu = !mobileMenu" v-bind:class="{'is-active':mobileMenu}">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="lg:flex lg:items-stretch lg:flex-no-shrink lg:flex-grow hidden" v-bind:class="{'is-active':mobileMenu}">
            <div class="lg:flex lg:items-stretch lg:justify-end ml-auto">
                <router-link to="/podcasts" class="flex-no-grow flex-no-shrink relative py-2 px-4 leading-normal text-white no-underline flex items-center">Podcasts</router-link>
                <a :href="logout" class="flex-no-grow flex-no-shrink relative py-2 px-4 leading-normal text-white no-underline flex items-center">Logout</a>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                mobileMenu: false,
            };
        },

        computed: {
            user: function() {
                return window.user;
            },

            logout: function() {
                return route('logout');
            },
        },
    }
</script>