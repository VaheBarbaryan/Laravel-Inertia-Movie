<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tags Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4 p-2 justify-end">
                    <Link :href="route('admin.tags.index')"
                          class="px-4 py-2 bg-green-600 hover:bg-green-800 text-white rounded-lg">
                        Tags Index
                    </Link>
                </div>
                <section class="container mx-auto p-6 font-mono">
                    <form @submit.prevent="storeTag">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full space-y-2 ">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Tag
                                            name</label>
                                        <input v-model="form.tagName" type="text" autocomplete="given-name"
                                               :class="{'border-red-500': props.errors.tagName}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                        <span v-if="props.errors.tagName"
                                              class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
			                                {{ props.errors.tagName }}
		                                </span>
                                    </div>
                                    <div>
                                        <button type="submit"
                                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded">
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import AdminLayout from "../../Layouts/AdminLayout.vue";
    import {Link, useForm} from '@inertiajs/vue3'
    import {defineProps} from 'vue';

    const props = defineProps({errors: Object});

    const form = useForm({
        tagName: null,
    });

    function storeTag() {
        form.post('/admin/tags');
    }
</script>

<style scoped>

</style>