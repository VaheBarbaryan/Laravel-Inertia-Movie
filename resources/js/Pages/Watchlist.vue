<template>
    <FrontLayout>
        <main class="my-2">
            <div class="max-w-6xl mx-auto m-4 p-2">
                <nav>
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                        <li @click="setActivetab('movies')" class="mr-2">
                            <a href="#" aria-current="page"
                               :class="activeTab === 'movies' ? 'inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500' : 'inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'">Movies
                                <span>({{ watchlist['movies'].length }})</span></a>
                        </li>
                        <li @click="setActivetab('tvShows')"
                            class="mr-2">
                            <a href="#"
                               :class="activeTab === 'tvShows' ? 'inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500' : 'inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300'">TV
                                Shows
                                <span>({{ watchlist['tvShows'].length }})</span></a>
                        </li>
                    </ul>
                </nav>
                <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded"
                         v-if="activeTab === 'movies'">
                    <div v-if="movies.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                        <MovieCard v-for="movie in movies" :key="movie.id">
                            <template #image>
                                <Link :href="route('movies.show', movie.slug)">
                                    <div class="aspect-w-2 aspect-h-3">
                                        <img class="object-cover"
                                             :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`">
                                    </div>
                                    <div class="absolute inset-0 z-10 bg-gradient-to-t from-black to-transparent"></div>
                                    <div
                                            class="absolute inset-y-0 left-5 z-10 invisible group-hover:visible flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-12 w-12 text-blue-700 bg-red-700 rounded-full" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        <div
                                                class="absolute transition opacity-0 duration-500 ease-in-out transform group-hover:opacity-100 group-hover:translate-x-16 group-hover:pr-2 text-white font-bold">
                                            Play
                                        </div>
                                    </div>
                                    <div class="absolute z-10 bottom-2 left-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">
                                        <span>{{ movie.release_date ? movie.release_date.split("-")[0] : '' }}</span>
                                    </div>
                                    <div v-if="movie.adult === 1"  class="absolute x-10 left-2 top-2 h-6 w-12 bg-gray-800 group-hover:bg-gray-700 text-blue-400 text-center rounded">
                                        18+
                                    </div>
                                    <div class="absolute z-10 bottom-2 right-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">
                                        <Rating :rating=" movie.rating"/>
                                    </div>
                                </Link>
                            </template>
                            <Link :href="route('movies.show', movie.slug)">
                                <div class="dark:text-white font-bold group-hover:text-blue-400">
                                    {{ movie.title }}
                                </div>
                            </Link>
                        </MovieCard>
                    </div>
                    <div v-else class="p-4">You haven't added any movies to your watchlist.</div>
                </section>
                <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded" v-else-if="activeTab === 'tvShows'">
                    <div  v-if="tvShows.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                        <MovieCard v-for="tvShow in tvShows" :key="tvShow.id">
                            <template #image>
                                <Link :href="route('tv-shows.show', tvShow.slug)">
                                    <div class="aspect-w-2 aspect-h-3">
                                        <img class="object-cover"
                                             :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${tvShow.poster_path}`">
                                    </div>
                                    <div class="absolute inset-0 z-10 bg-gradient-to-t from-black to-transparent"></div>
                                    <div
                                            class="absolute inset-y-0 left-5 z-10 invisible group-hover:visible flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-12 w-12 text-blue-700 bg-red-700 rounded-full"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        <div class="absolute transition opacity-0 duration-500 ease-in-out transform group-hover:opacity-100 group-hover:translate-x-16 group-hover:pr-2 text-white font-bold">
                                            Play
                                        </div>
                                    </div>
                                    <div class="absolute z-10 bottom-2 left-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">
                                        <span>{{tvShow.created_year ? tvShow.created_year.split("-")[0] : ''}}</span>
                                    </div>
                                    <div v-if="tvShow.adult === 1"  class="absolute x-10 left-2 top-2 h-6 w-12 bg-gray-800 group-hover:bg-gray-700 text-blue-400 text-center rounded">
                                        18+
                                    </div>
                                    <div class="absolute z-10 bottom-2 right-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">
                                        <Rating :rating=" tvShow.rating"/>
                                    </div>
                                </Link>
                            </template>
                            <Link :href="route('tv-shows.show', tvShow.slug)">
                                <div class="dark:text-white font-bold group-hover:text-blue-400">
                                    {{ tvShow.name }}
                                </div>
                            </Link>
                        </MovieCard>
                    </div>
                    <div v-else class="p-4">You haven't added any TV shows to your watchlist.</div>
                </section>
                <!--                <MovieCard  v-for="watch in watchlist[watchs]" :key="watch.id">-->
                <!--                    <template #image>-->
                <!--                        <Link :href="watchs === 'movies' ? route('movies.show', watch.slug) : route('tv-shows.show', watch.slug)">-->
                <!--                            <div class="aspect-w-2 aspect-h-3">-->
                <!--                                <img class="object-cover"-->
                <!--                                     :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${watch.poster_path}`">-->
                <!--                            </div>-->
                <!--                            <div class="absolute inset-0 z-10 bg-gradient-to-t from-black to-transparent"></div>-->
                <!--                            <div-->
                <!--                                    class="absolute inset-y-0 left-5 z-10 invisible group-hover:visible flex items-center">-->
                <!--                                <svg xmlns="http://www.w3.org/2000/svg"-->
                <!--                                     class="h-12 w-12 text-blue-700 bg-red-700 rounded-full"-->
                <!--                                     viewBox="0 0 20 20"-->
                <!--                                     fill="currentColor">-->
                <!--                                    <path fill-rule="evenodd"-->
                <!--                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"-->
                <!--                                          clip-rule="evenodd"/>-->
                <!--                                </svg>-->
                <!--                                <div-->
                <!--                                        class="absolute transition opacity-0 duration-500 ease-in-out transform group-hover:opacity-100 group-hover:translate-x-16 group-hover:pr-2 text-white font-bold">-->
                <!--                                    Play-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="absolute z-10 bottom-2 left-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">-->
                <!--                                <span>{{ watchs === 'movies' ? (watch.release_date ? watch.release_date.split("-")[0] : '') : (watch.created_year ? watch.created_year.split("-")[0] : '') }}</span>-->

                <!--                            </div>-->
                <!--                            <div class="absolute z-10 bottom-2 right-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">-->
                <!--                                <Rating :rating=" watch.rating"/>-->
                <!--                            </div>-->
                <!--                        </Link>-->
                <!--                    </template>-->
                <!--                    <Link :href="watchs === 'movies' ? route('movies.show', watch.slug) : route('tv-shows.show', watch.slug)">-->
                <!--                        <div class="dark:text-white font-bold group-hover:text-blue-400">-->
                <!--                            {{ watchs === 'movies' ? watch.title : watch.name }}-->
                <!--                        </div>-->
                <!--                    </Link>-->
                <!--                </MovieCard>-->
            </div>
        </main>
    </FrontLayout>
</template>

<script setup>
    import {defineProps, ref} from 'vue'
    import FrontLayout from '@/Layouts/FrontLayout.vue'
    import MovieCard from '@/Components/MovieCard.vue'
    import Rating from '@/Components/Rating.vue'
    import {Head, Link} from '@inertiajs/vue3';

    const props = defineProps({
        tvShows: Array,
        movies: Array
    })

    console.log("movies", props.movies)
    console.log("tvShows", props.tvShows)

    const activeTab = ref('movies')

    const watchlist = ref({
        movies: props.movies,
        tvShows: props.tvShows,
    })

    function setActivetab(value) {
        activeTab.value = value;
    }

</script>

<style scoped>

</style>