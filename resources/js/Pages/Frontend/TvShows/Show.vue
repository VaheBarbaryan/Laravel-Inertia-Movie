<template>
    <Head :title="`${tvShow.name} Tv Show`" />
    <FrontLayout>
        <main v-if="tvShow" class="my-2">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded"
                                     :src="`https://www.themoviedb.org/t/p/w300_and_h450_bestv2/${tvShow.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">{{ tvShow.name }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>{{ created_year }}</span>
                                </div>
                                <div class="flex m-2 mt-0 items-center">
                                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor"
                                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Rating
                                        star</title>
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <p class="ml-2 text-md font-bold text-white">{{ tvShow?.rating }}</p>
                                    <span class="w-1 h-1 mx-1.5 bg-white rounded-full dark:bg-gray-400"></span>
                                    <span class="text-sm font-medium hover:no-underline text-white">{{ tvShow.rate_count ? tvShow.rate_count : '-' }} ratings</span>
                                    <span v-if="tvShow.adult === 1" class="w-1 h-1 mx-1.5 bg-white rounded-full dark:bg-gray-400"></span>
                                    <span v-if="tvShow.adult === 1" class="text-sm font-medium hover:no-underline text-white">18+</span>
                                </div>
                                <div class="flex align-center gap-2 m-2 mt-0 items-center">
                                    <h3 class="font-bold text-xl hover:no-underline text-white">Time: </h3>
                                    <span class="font-medium hover:no-underline text-white">{{ time }}</span>
                                </div>
                                <div class="flex align-center gap-2 m-2 mt-0 items-center">
                                    <h3 class="font-bold text-xl hover:no-underline text-white">Episodes number: </h3>
                                    <span class="font-medium hover:no-underline text-white">{{ tvShow.number_of_episodes ? tvShow.number_of_episodes : '-' }}</span>
                                </div>
                                <div class="flex align-center gap-2 m-2 mt-0 items-center">
                                    <h3 class="font-bold text-xl hover:no-underline text-white">Seasons number: </h3>
                                    <span class="font-medium hover:no-underline text-white">{{ tvShow.number_of_seasons ? tvShow.number_of_seasons : '-' }}</span>
                                </div>
                                <div class="flex align-center gap-2 m-2 mt-0 items-center">
                                    <button @click="addRemoveToWatchlist"  :title="is_added_to_watchlist ? 'Remove from watchlist' : 'Add to watchlist'" type="button"
                                            class="rounded-full bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                    >
                                        <div v-if="!is_added_to_watchlist">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="16" height="16" fill="#fff"
                                                 class="bi bi-bookmark"
                                                 viewBox="0 0 16 16">
                                                <path
                                                        d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                            </svg>
                                        </div>
                                        <div v-else>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-bookmark-fill"
                                                 viewBox="0 0 16 16">
                                                <path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1 class="flex text-slate-600 dark:text-white font-bold text-xl mb-4">Seasons</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard v-for="season in seasons" :key="season.id">
                                <template #image>
                                    <a :href="route('seasons.show', [tvShow.slug, season.slug])">
                                        <img class=""
                                             :src="season.poster_path ? `https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}` : ''">
                                    </a>
                                </template>
                                <Link :href="route('seasons.show', [tvShow.slug, season.slug])">
                                    <span class="text-black dark:text-white">{{ season.name }}</span>
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                    <div class="w-4/12">
                        <h1 class="flex text-slate-600 dark:text-white font-bold text-xl mb-4">Latest movies</h1>
                        <div class="grid grid-cols-3 gap-2" v-if="latests">
                            <Link v-for="movie in latests" :key="movie.id"
                                  :href="route('movies.show', movie.slug)">
                                <img class="w-full h-full rounded-lg"
                                     :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${ movie.poster_path }`">
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
            <section v-if="tags" class="max-w-6xl mx-auto bg-gradient-to-r from-indigo-700 to-transparent mt-6 p-2">
                <span v-for="tag in tags" :key="tag.id"
                      class="font-bold text-white hover:text-indigo-200 cursor-pointer">
                        <Link class="ml-2" :href="route('tags.index',tag.slug)">#{{ tag.tag_name }}</Link>
                </span>
            </section>
        </main>
    </FrontLayout>
</template>

<script setup>
    import {defineProps, ref} from 'vue';
    import {Link, Head, router} from '@inertiajs/vue3';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import MovieCard from '@/Components/MovieCard.vue';

    const props = defineProps({
        tvShow: Object,
        latests: Array,
        seasons: Array,
        is_added_to_watchlist: Boolean
    });

    const created_year = convertDate(props.tvShow.created_year)
    const time = toHoursAndMinutes(props.tvShow.episode_run_time ? props.tvShow.episode_run_time : 0)

    function toHoursAndMinutes(totalMinutes) {
        let hours = Math.floor(totalMinutes / 60);
        let minutes = totalMinutes % 60;
        let res = ""
        if (hours !== 0) {
            hours = "0" + hours + "h "
            res += hours
        }
        if (minutes < 10) {
            minutes = "0" + minutes + "m"
        } else {
            minutes = minutes + "m"
        }
        res += minutes
        // return { hours, minutes };
        return res
    }

    function addRemoveToWatchlist() {
        router.post(`/tv-shows/${props.tvShow.slug}/watchlist`);
    }

    function convertDate(date_str) {
        let temp_date = date_str.toString().split("-");
        let month = new Date(date_str).toLocaleString('default', { month: 'long' })
        return `${temp_date[2]} ${month} ${temp_date[0]}`
    }
</script>