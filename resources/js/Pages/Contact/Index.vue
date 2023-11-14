<template>
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contact Us
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <section class="container mx-auto p-6 font-mono">
                    <form @submit.prevent="updateContact">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full space-y-2 ">
                                    <div class="mb-2">
                                        <label for="facebook" class="block text-sm font-medium text-gray-700">Facebook
                                            link</label>
                                        <input id="facebook" v-model="form.facebook" type="text" autocomplete="given-name"
                                               :class="{'border-red-500': form.errors.facebook}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                        <span v-if="form.errors.facebook"
                                              class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
			                                {{ form.errors.facebook }}
		                                </span>
                                    </div>
                                    <div class="mb-2">
                                        <label for="twitter" class="block text-sm font-medium text-gray-700">Twitter
                                            link</label>
                                        <input id="twitter" v-model="form.twitter" type="text" autocomplete="given-name"
                                               :class="{'border-red-500': form.errors.twitter}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                        <span v-if="form.errors.twitter"
                                              class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
			                                {{ form.errors.twitter }}
		                                </span>
                                    </div>
                                    <div class="mb-2">
                                        <label for="instagram" class="block text-sm font-medium text-gray-700">Inatagram
                                            link</label>
                                        <input id="instagram" v-model="form.instagram" type="text" autocomplete="given-name"
                                               :class="{'border-red-500': form.errors.instagram}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                        <span v-if="form.errors.instagram"
                                              class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
			                                {{ form.errors.instagram }}
		                                </span>
                                    </div>
                                    <div class="mb-2">
                                        <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn
                                            link</label>
                                        <input id="linkedin" v-model="form.linkedin" type="text" autocomplete="given-name"
                                               :class="{'border-red-500': form.errors.linkedin}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                        <span v-if="form.errors.linkedin"
                                              class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
			                                {{ form.errors.linkedin }}
		                                </span>
                                    </div>
                                    <div>
                                        <button type="submit"
                                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded">
                                            Update
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
    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import { useForm } from '@inertiajs/vue3'
    import {defineProps} from 'vue'

    const props = defineProps({
        contact: Object
    })

    const form = useForm({
        facebook: props.contact.facebook,
        twitter: props.contact.twitter,
        instagram: props.contact.instagram,
        linkedin: props.contact.linkedin,
    })

    function updateContact() {
        form.put('/admin/contact_us')
    }

</script>

<style scoped>

</style>