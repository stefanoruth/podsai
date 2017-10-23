<template>
    <nav class="navbar is-dark">
        <div class="navbar-brand">

            <div class="navbar-item">
                <p class="control has-addons">
                    <search-field></search-field>
                </p>
            </div>

            <div class="navbar-item">{{ user }}</div>

            <button class="button navbar-burger is-dark" v-on:click="mobileMenu = !mobileMenu" v-bind:class="{'is-active':mobileMenu}">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="navbar-menu" v-bind:class="{'is-active':mobileMenu}">
            <div class="navbar-end">
                <router-link to="/" class="navbar-item">Home</router-link>
                <a :href="logout" class="navbar-item">Logout</a>
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