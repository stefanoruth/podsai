<template>
    <nav class="relative select-none bg-grey lg:flex lg:items-stretch">
        <div class="flex flex-no-shrink items-stretch h-12">
            <router-link to="/" class="flex-no-grow flex-no-shrink relative py-2 px-4 leading-normal text-white no-underline flex items-center hover:bg-grey-dark">Podsai</router-link>
            <button class="block lg:hidden cursor-pointer ml-auto relative w-12 h-12 p-4" @click="mobileMenu = !mobileMenu">
                <svg v-show="!mobileMenu" class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                <svg v-show="mobileMenu" class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
            </button>
        </div>
        <div class="lg:flex lg:items-stretch lg:flex-no-shrink lg:flex-grow" v-bind:class="{'hidden':!mobileMenu}">
            <div class="lg:flex lg:items-stretch lg:justify-end ml-auto">
                <router-link :to="{name:'podcasts.create'}" class="flex-no-grow flex-no-shrink relative py-2 px-4 leading-normal text-white no-underline flex items-center hover:bg-grey-dark">Add Podcast</router-link>
                <router-link :to="{name:'podcasts.index'}" class="flex-no-grow flex-no-shrink relative py-2 px-4 leading-normal text-white no-underline flex items-center hover:bg-grey-dark">Podcasts</router-link>
                <a :href="logout" class="flex-no-grow flex-no-shrink relative py-2 px-4 leading-normal text-white no-underline flex items-center hover:bg-grey-dark">Logout</a>
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