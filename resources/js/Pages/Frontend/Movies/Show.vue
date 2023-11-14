<template>
    <Head :title="`${movie.title} Movie`"/>
    <FrontLayout>
        <main v-if="movie" class="my-2">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <!--                     :style="{backgroundImage: movie_backdrop, backgroundRepeat: 'no-repeat',backgroundPosition: 'left calc((50vw - 170px) - 340px)'}">-->
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded"
                                     :src="`https://www.themoviedb.org/t/p/w300_and_h450_bestv2/${movie.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">{{ movie.title }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>{{ release_date }}</span>
                                    <span class="ml-2 space-x-1">
                                            <Link v-for="(genre,index) in movie_genres" :key="genre.id"
                                                  class="font-bold"
                                                  :href="route('genres.show',genre.slug)">
                                                <span class="hover:underline">{{ genre.title }}</span><span
                                                    v-if="index < movie_genres.length - 1">, </span>
                                            </Link>
                                    </span>
                                    <span class="flex space-x-2">
                                        <div>
                                            {{ runtime }}
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                </div>

                                <div class="flex m-2 mt-0 items-center">
                                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor"
                                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Rating
                                        star</title>
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <p class="ml-2 text-md font-bold text-white">{{ movie.rating }}</p>
                                    <span class="w-1 h-1 mx-1.5 bg-white rounded-full dark:bg-gray-400"></span>
                                    <span class="text-sm font-medium hover:no-underline text-white">{{ movie?.rate_count }} ratings</span>
                                    <span v-if="movie.adult === 1" class="w-1 h-1 mx-1.5 bg-white rounded-full dark:bg-gray-400"></span>
                                    <span v-if="movie.adult === 1" class="text-sm font-medium hover:no-underline text-white">18+</span>
                                </div>

                                <div class="flex space-x-4">
                                    <button @click="openModal(trailer)" type="button"
                                            class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                            v-for="trailer in trailers" :key="trailer.id">{{ trailer.name }}
                                    </button>
                                </div>
                                <div class="flex space-x-4 mt-4">
                                    <button @click="addRemoveToWatchlist"
                                            :title="is_added_to_watchlist ? 'Remove from watchlist' : 'Add to watchlist'"
                                            type="button"
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
                            <!--                            <div class="pl-8 text-white">-->
                            <!--                                -->
                            <!--                            </div>-->
                            <div class="p-8 text-white">
                                <p>{{ movie.overview }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4" v-if="downloads.length">
                        <h3 class="text-2xl font-semibold text-white">Download movie</h3>
                        <div class="flex space-x-4 mt-2">
                            <a :href="download.web_url" target="_blank"
                               class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                               v-for="download in downloads" :key="download.id">{{ download.name }}
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1 class="flex text-slate-600 dark:text-white font-bold text-xl mb-4">Movie Casts</h1>
                        <div class="flex flex-no-wrap overflow-x-scroll scrolling-touch items-start gap-4 mt-4 p-2">
                            <!--                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">-->
                            <MovieCard class="flex-shrink-0 w-40" v-for="cast in casts" :key="cast.id">
                                <template #image>
                                    <a :href="route('casts.show', cast.slug)">
                                        <img class="object-cover h-48 w-full"
                                             :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`">
                                    </a>
                                </template>
                                <Link :href="route('casts.show', cast.slug)">
                                    <span class="text-slate-600 dark:text-white">{{ cast.name }}</span>
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
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-75"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                                class="w-full max-w-6xl transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 text-left align-middle shadow-xl transition-all">
                            <div class="mt-2" v-if="modalTrailer">
                                <div class="aspect-w-16 aspect-h-9" v-html="modalTrailer.embed_html"></div>
                            </div>

                            <div class="mt-4">
                                <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="closeModal"
                                >
                                    Close
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
    import {defineProps, ref, computed} from 'vue';
    import {Link, Head, router} from '@inertiajs/vue3';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import MovieCard from '@/Components/MovieCard.vue';
    import {
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogPanel,
        DialogTitle,
    } from '@headlessui/vue';

    const props = defineProps({
        movie: Object,
        latests: Array,
        casts: Array,
        tags: Array,
        movie_genres: Array,
        trailers: Array,
        downloads: Array,
        is_added_to_watchlist: Boolean
    });

    const isOpen = ref(false);
    const modalTrailer = ref({});
    const runtime = toHoursAndMinutes(props.movie.runtime)
    const release_date = convertDate(props.movie.release_date)

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
        router.post(`/movies/${props.movie.slug}/watchlist`);
    }

    function convertDate(date_str) {
        let temp_date = date_str.split("-");
        let month = new Date(date_str).toLocaleString('default', {month: 'long'})
        return `${temp_date[2]} ${month} ${temp_date[0]}`
    }

    function closeModal() {
        isOpen.value = false
    }

    function openModal(trailer) {
        modalTrailer.value = trailer;
        isOpen.value = true
    }
</script>

<style scoped>
</style>