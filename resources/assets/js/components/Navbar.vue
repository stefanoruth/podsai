<template>
    <div class="bg-white border-t-8 border-orange">
        <nav class="max-w-2xl mx-auto relative select-none md:flex md:items-stretch">
            <div class="flex flex-no-shrink items-stretch">
                <router-link to="/" class="flex-no-grow flex-no-shrink relative p-4 md:p-8 leading-normal text-black text-2xl font-black text-grey-darkest no-underline flex items-center hover:bg-orange hover:text-white">Podsai</router-link>
                <button class="block md:hidden cursor-pointer ml-auto relative p-4" @click="mobileMenu = !mobileMenu">
                    <div class="h-6 w-6">
                        <svg v-show="!mobileMenu" class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                        <svg v-show="mobileMenu" class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                    </div>
                </button>
            </div>
            <div class="md:flex md:items-stretch md:flex-no-shrink md:flex-grow border-b md:border-b-0" v-bind:class="{'hidden':!mobileMenu}">
                <div class="md:flex md:items-stretch md:justify-end ml-auto">
                    <router-link :to="{name:'podcasts.index'}" @click.native="mobileMenu = false" class="flex-no-grow flex-no-shrink relative py-4 px-2 md:py-8 md:px-4 leading-normal text-black no-underline flex items-center hover:bg-orange hover:text-white">Podcasts</router-link>
                    <router-link :to="{name:'episodes.latest'}" @click.native="mobileMenu = false" class="flex-no-grow flex-no-shrink relative py-4 px-2 md:py-8 md:px-4 leading-normal text-black no-underline flex items-center hover:bg-orange hover:text-white">Episodes</router-link>
                    <a :href="logout" class="flex-no-grow flex-no-shrink relative py-4 px-2 md:py-8 md:px-4 leading-normal text-black no-underline flex items-center hover:bg-orange hover:text-white">Logout</a>
                </div>
            </div>
        </nav>
    </div>
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

        mounted() {
            document.querySelector('main').addEventListener('click', e => {
                if (this.mobileMenu) {
                    this.mobileMenu = false;
                }
            });
        }
    }
</script>