<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ tvShow ? tvShow.name : '' }} Seasons Index
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 justify-end">
                        <form class="flex space-x-4 shadow bg-white rounded-md m-2 p-2">
                            <div class="p-1">
                                <button type="button" @click="generateSeason"
                                        class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-green-700 transition duration-150 ease-in-out disabled:opacity-50">
                                    <span>Generate</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg bg-white">
                        <div>
                            <div class="flex justify-between p-5">
                                <div class="flex-1">
                                    <div class="relative">
                                        <div class="absolute flex items-center ml-2 h-full">
                                            <svg class="w-4 h-4 fill-current text-primary-gray-dark" viewBox="0 0 16 16"
                                                 fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                                                </path>
                                            </svg>
                                        </div>

                                        <input v-model="search" type="text" placeholder="Search by title"
                                               class="px-8 py-3 w-full md:w-2/6 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"/>
                                    </div>
                                </div>
                                <div class="flex">
                                    <select v-model="perPage" @change="getSeasons"
                                            class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                        <option value="5">5 Per Page</option>
                                        <option value="10">10 Per Page</option>
                                        <option value="15">15 Per Page</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="w-full overflow-x-auto">
                            <Table>
                                <template #tableHead>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Slug</TableHead>
                                    <TableHead>Season Number</TableHead>
                                    <TableHead>Poster</TableHead>
                                    <TableHead>Manage</TableHead>
                                </template>
                                <TableRow v-for="season in seasons.data" :key="season.id">
                                    <TableData>{{ season.name }}</TableData>
                                    <TableData>{{ season.slug }}</TableData>
                                    <TableData>{{ season.season_number }}</TableData>
                                    <TableData style="text-align: center">
                                        <img class="h-24 w-24 rounded inline"
                                             :src="season.poster_path ? `https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}` : ''"
                                             alt="Poster">
                                    </TableData>
                                    <TableData style="text-align: center;">
                                        <ButtonLink class="!bg-blue-500 hover:!bg-blue-700"
                                                    :link="route('admin.episodes.index',[tvShow.id,season.id])">
                                            Episodes
                                        </ButtonLink>
                                        <ButtonLink :link="route('admin.seasons.edit',[tvShow.id,season.id])">Edit
                                        </ButtonLink>
                                        <ButtonLink class="bg-red-500 hover:bg-red-700" method="delete" as="button"
                                                    type="button"
                                                    :link="route('admin.seasons.destroy',[tvShow.id,season.id])">
                                            Delete
                                        </ButtonLink>
                                    </TableData>
                                </TableRow>
                            </Table>
                            <div class="m-2 p-2">
                                <Pagination :links="seasons.links"/>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import Table from "@/Components/Table.vue";
    import TableHead from "@/Components/TableHead.vue";
    import TableData from "@/Components/TableData.vue";
    import TableRow from "@/Components/TableRow.vue";
    import ButtonLink from "@/Components/ButtonLink.vue";
    import {Link, router} from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';
    import {ref, watch, defineProps} from 'vue';

    const props = defineProps({
        tvShow: Object,
        seasons: Array,
        filters: Object
    });

    const search = ref(props.filters.search);
    const perPage = ref(props.filters.perPage ? props.filters.perPage : 5);
    const seasonNumber = ref('');

    watch(search, (value) => {
        router.get(`/admin/tv-shows/${props.tvShow.id}/seasons`, {search: value, perPage: perPage.value}, {
            preserveState: true,
            replace: true
        });
    });

    function getSeasons() {
        router.get(`/admin/tv-shows/${props.tvShow.id}/seasons`, {perPage: perPage.value, search: search.value}, {
            preserveState: true,
            replace: true
        });
    }

    function generateSeason() {
        router.post(`/admin/tv-shows/${props.tvShow.id}/seasons`, {seasonNumber: seasonNumber.value}, {
            onFinish: () => (seasonNumber.value = "")
        });
    }
</script>

<style scoped>

</style>