<template>
    <div class="fixed pin flex">
        <div class="bg-orange absolute pin opacity-75" @click="$emit('close')"></div>
        <div class="flex flex-1 justify-center items-center p-4" @click.stop>
            <div class="bg-white border shadow relative max-h-90 overflow-y-scroll flex flex-col" :class="cssScope">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['cssScope'],

        mounted() {
            document.addEventListener('keydown', e => {
                if (e.keyCode == 27) {
                    this.$emit('close');
                }
            });
        },
    };
</script>