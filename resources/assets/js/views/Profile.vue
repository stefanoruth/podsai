<template>
    <div v-if="user != null">
        <img :src="user.avatar">
        <div>{{ user.name }}</div>
        <div>{{ user.email }}</div>
        <div>Member Since: {{ user.joined }}</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: null,
            };
        },

        mounted() {
            axios.get(route('users.index')).then(res => {
                this.user = res.data.data;
            });
        }
    }
</script>
