<template>
    <div class="flex">
        <template v-for="(link, key) in links" :key="key">
            <div v-if="link.url === null" v-html="link.label"
                 class="mb-1 mr-1 px-4 py-3 text-black text-sm leading-4 border border-slate-500 rounded"></div>
            <Link v-else :href="link.url" v-html="link.label"
                  class="mb-1 mr-1 px-4 py-3 text-black text-sm leading-4 border border-slate-500 rounded focus:text-indigo-500 focus:border-indigo-500 hover:bg-white"
                  :class="link.active ? 'bg-indigo-200' : ''"/>
        </template>
    </div>
</template>

<script setup>
    import {Link} from '@inertiajs/vue3';
    import {defineProps} from 'vue';

    defineProps({
        links: Array
    })
</script>

<style scoped>

</style>