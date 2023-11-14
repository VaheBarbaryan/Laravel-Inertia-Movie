<template>
    <Head :title="`${cast.name}`"/>
    <FrontLayout>
        <main v-if="cast" class="my-2">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded"
                                     :src="`https://www.themoviedb.org/t/p/w300_and_h450_bestv2/${cast.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white dark:text-white font-bold text-4xl">
                                    {{ cast.name }}
                                </h1>
                                <h2 class="text-white dark:text-white text-2xl font-bold mt-4">Biography</h2>
                                <div class="mt-2">
                                    <p class="text-white dark:text-white" v-if="cast.biography">{{ cast.biography }}</p>
                                    <p class="text-white dark:text-white" v-else>We don't have a biography for {{ cast.name }}</p>
                                </div>
                                <div class="flex gap-10">
                                    <div>
                                        <h2 class="text-white dark:text-white text-2xl font-bold mt-4">Birthday</h2>
                                        <div class="mt-2">
                                            <p class="text-white dark:text-white" v-if="cast.birthday">{{ birthday }} <span v-if="!cast.deathday">({{ (new Date().getFullYear() - cast.birthday.split('-')[0]) }} years old)</span></p>
                                            <p class="text-white dark:text-white" v-else>-</p>
                                        </div>
                                    </div>
                                    <div v-if="cast.deathday">
                                        <h2 class="text-white dark:text-white text-2xl font-bold mt-4">Deathday</h2>
                                        <div class="mt-2">
                                            <p class="text-white dark:text-white" v-if="cast.deathday">{{ deathday }} <span>({{ (cast.deathday.split('-')[0] - cast.birthday.split('-')[0]) }} years old)</span></p>
                                            <p class="text-white dark:text-white" v-else>-</p>
                                        </div>
                                    </div>
                                </div>
                                <h2 class="text-white dark:text-white text-2xl font-bold mt-4">Place of birth</h2>
                                <div class="mt-2">
                                    <p class="text-white dark:text-white" v-if="cast.place_of_birth">{{ cast.place_of_birth }}</p>
                                    <p class="text-white dark:text-white" v-else>-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-8/12">
                        <h1 class="flex text-slate-600 dark:text-white font-bold text-xl mb-4">{{ cast.name }} Movies</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4" v-if="movies">
                            <MovieCard v-for="movie in movies" :key="movie.id">
                                <template #image>
                                    <a :href="route('movies.show', movie.slug)">
                                        <img class=""
                                             :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`">
                                    </a>
                                </template>
                                <Link :href="route('movies.show', movie.slug)">
                                    <span class="text-slate-600 dark:text-white">{{ movie.title }}</span>
                                </Link>
                            </MovieCard>
                        </div>
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
        cast: Object,
        movies: Array,
    });

    const birthday = convertDate(props.cast?.birthday)
    const deathday = convertDate(props.cast?.deathday)

    function convertDate(date_str) {
        if(!date_str) {
            return null
        }
        let temp_date = date_str.split("-");
        let month = new Date(date_str).toLocaleString('default', {month: 'long'})
        return `${temp_date[2]} ${month} ${temp_date[0]}`
    }

</script>