<template>
    <Head :title="`${episode.name} Episode`"/>
    <FrontLayout>
        <main v-if="episode" class="my-2">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded"
                                     :src="`https://www.themoviedb.org/t/p/w300_and_h450_bestv2/${season.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-blue-600 font-bold text-4xl">{{ episode.name }}</h1>
                                <div class="text-white mt-2 pb-2">
                                    <h2>Season: {{ season.name }}</h2>
                                </div>
                                <div class="flex text-white">
                                    <span>Episode Nr: {{ episode.episode_number }}</span>
                                </div>
                                <div class="text-white p-3">
                                    <span>{{ episode.overview }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-8/12">
                        <h1 class="flex text-slate-600 dark:text-white font-bold text-xl mb-4">Latest episodes</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4" v-if="latests">
                            <MovieCard v-for="episode in latests" :key="episode.id">
                                <template #image>
                                    <a :href="route('episodes.show', episode.slug)">
                                        <img class=""
                                             :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`">
                                    </a>
                                </template>
                                <Link :href="route('episodes.show', episode.slug)">
                                    <span class="text-slate-600 dark:text-white">{{ episode.name }}</span>
                                </Link>
                            </MovieCard>
                        </div>
<!--                        <div class="grid grid-cols-3 gap-2" v-if="latests">-->
<!--                            <Link v-for="episode in latests" :key="episode.id"-->
<!--                                  :href="route('episodes.show', episode.slug)">-->
<!--                                <img class="w-full h-full rounded-lg"-->
<!--                                     :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${ season.poster_path }`">-->
<!--                            </Link>-->
<!--                        </div>-->
                    </div>
                </div>
            </section>
        </main>
    </FrontLayout>
</template>

<script setup>
    import {defineProps, ref} from 'vue';
    import {Link, Head} from '@inertiajs/vue3';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import MovieCard from '@/Components/MovieCard.vue';

    const props = defineProps({
        episode: Object,
        latests: Array,
        season: Object
    });
    console.log(props.season)
</script>