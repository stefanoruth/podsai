<template>
    <div class="fixed pin flex z-20">
        <div class="bg-orange absolute pin opacity-75" @click="$emit('close')"></div>
        <div class="flex flex-1 justify-center items-center p-4" @click.stop>
            <div class="bg-white border shadow relative max-h-90 overflow-y-scroll flex flex-col" :class="cssScope">
                <div v-show="loading" class="absolute pin bg-orange flex justify-center items-center">
                    <svg class="h-24 w-24 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M3 18a7 7 0 0 1 4-6.33V8.33A7 7 0 0 1 3 2H1V0h18v2h-2a7 7 0 0 1-4 6.33v3.34A7 7 0 0 1 17 18h2v2H1v-2h2zM5 2a5 5 0 0 0 4 4.9V10h2V6.9A5 5 0 0 0 15 2H5z"/></svg>
                </div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            cssScope: {
                type: String,
            },
            loading: {
                type: Boolean,
                default: false,
            },
        },

        mounted() {
            document.addEventListener('keydown', e => {
                if (e.keyCode == 27) {
                    this.$emit('close');
                }
            });
        },
    };
</script>