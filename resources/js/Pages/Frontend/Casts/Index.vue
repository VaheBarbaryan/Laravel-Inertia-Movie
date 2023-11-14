<script setup>
    import {defineProps} from 'vue';
    import {Head, Link} from '@inertiajs/vue3';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import MovieCard from '@/Components/MovieCard.vue';
    import Pagination from '@/Components/Pagination.vue';

    defineProps({
        casts: Array,
    });
</script>

<template>
    <Head title="Welcome"/>
    <FrontLayout>
        <main class="max-w-6xl mx-auto mt-6 pb-6 min-h-screen">
            <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
                <div class="m-2 p-2 text-2xl font-bold text-indigo-600 dark:text-indigo-300">
                    <h1>Casts</h1>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                    <MovieCard v-for="cast in casts.data" :key="cast.id">
                        <template #image>
                            <Link :href="route('casts.show', cast.slug)">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img class="object-cover"
                                         :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`">
                                </div>
                            </Link>
                        </template>
                        <Link :href="route('casts.show', cast.slug)">
                            <div class="dark:text-white font-bold group-hover:text-blue-400">
                                {{ cast.name }}
                            </div>
                        </Link>
                    </MovieCard>
                </div>
                <div class="m-2 p-2">
                    <Pagination :links="casts.links"/>
                </div>
            </section>
        </main>
    </FrontLayout>
</template>
