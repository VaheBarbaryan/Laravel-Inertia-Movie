<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ movie ? movie.title : '' }} - Movie Attach
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 justify-end">
                        <Link :href="route('admin.movies.index')"
                              class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            Movies Index
                        </Link>
                    </div>
                    <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white">
                        <div class="flex space-x-2">
                            <div v-for="trailer in trailers" :key="trailer.id">
                                <Link class="flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 rounded"
                                      :href="route('admin.trailers.desroy',trailer.id)"
                                      method="delete" as="button"
                                      type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    <div>
                                        {{ trailer.name }}
                                    </div>
                                </Link>
                            </div>
                        </div>
                        <form @submit.prevent="submitTrailer" novalidate>
                            <div>
                                <InputLabel for="name" value="Name"/>
                                <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.name ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.name"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="embed_html" value="Poster Path"/>
                                <textarea
                                        id="embed_html"
                                        v-model="form.embed_html"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.embed_html ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.embed_html"/>
                            </div>

                            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                                <InputLabel for="terms">
                                    <div class="flex items-center">
                                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required/>

                                        <div class="ml-2">
                                            I agree to the <a target="_blank" :href="route('terms.show')"
                                                              class="underline text-sm text-gray-600 hover:text-gray-900">Terms
                                            of Service</a> and <a target="_blank" :href="route('policy.show')"
                                                                  class="underline text-sm text-gray-600 hover:text-gray-900">Privacy
                                            Policy</a>
                                        </div>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.terms"/>
                                </InputLabel>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Add trailer
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                    <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white">
                        <div class="flex space-x-2">
                            <div v-for="download in downloads" :key="download.id">
                                <Link class="flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 rounded"
                                      :href="route('admin.downloads.destroy',download.id)"
                                      method="delete" as="button"
                                      type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    <div>
                                        {{ download.name }}
                                    </div>
                                </Link>
                            </div>
                        </div>
                        <form @submit.prevent="submitDownload" novalidate>
                            <div>
                                <InputLabel for="name" value="Name"/>
                                <TextInput
                                        id="name"
                                        v-model="formDownload.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="formDownload.errors.name ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="formDownload.errors.name"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="web_url" value="Url"/>
                                <TextInput
                                        id="web_url"
                                        v-model="formDownload.web_url"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="formDownload.errors.web_url ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="formDownload.errors.web_url"/>
                            </div>

                            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                                <InputLabel for="terms">
                                    <div class="flex items-center">
                                        <Checkbox id="terms" v-model:checked="formDownload.terms" name="terms" required/>

                                        <div class="ml-2">
                                            I agree to the <a target="_blank" :href="route('terms.show')"
                                                              class="underline text-sm text-gray-600 hover:text-gray-900">Terms
                                            of Service</a> and <a target="_blank" :href="route('policy.show')"
                                                                  class="underline text-sm text-gray-600 hover:text-gray-900">Privacy
                                            Policy</a>
                                        </div>
                                    </div>
                                    <InputError class="mt-2" :message="formDownload.errors.terms"/>
                                </InputLabel>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': formDownload.processing }"
                                               :disabled="formDownload.processing">
                                    Add download
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                    <div class="w-full mb-8 p-6 rounded-lg shadow-lg bg-white">
                        <div>
                            <form @submit.prevent="submitCast">
                                <Multiselect v-model="castForm.casts" :options="casts" mode="tags"
                                             searchable="true"></Multiselect>
                                <div>
                                    <PrimaryButton class="ml-4 mt-4" :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        Add cast
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white"
                         style="overflow: visible">
                        <div>
                            <form @submit.prevent="submitTag">
                                <Multiselect v-model="tagForm.tags" :options="tags" mode="tags"
                                             searchable="true"></Multiselect>
                                <div>
                                    <PrimaryButton class="ml-4 mt-4" :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        Add tag
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import AdminLayout from "../../Layouts/AdminLayout.vue";
    import {Link, router, useForm} from '@inertiajs/vue3';
    import {ref, defineProps} from 'vue';
    import AuthenticationCard from '@/Components/AuthenticationCard.vue';
    import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
    import Checkbox from '@/Components/Checkbox.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import FormSelect from '@/Components/FormSelect.vue';
    import Multiselect from '@vueform/multiselect'

    const props = defineProps({
        movie: Object,
        trailers: Array,
        downloads: Array,
        casts: Array,
        tags: Array,
        movie_casts: Array,
        movie_tags: Array,
    });

    const value = ref(null);
    const form = useForm({
        name: '',
        embed_html: ''
    });
    const formDownload = useForm({
        name: '',
        web_url: ''
    })

    const castForm = useForm({
        casts: []
    });
    const tagForm = useForm({
        tags: []
    });
    castForm.casts = props?.movie_casts;
    tagForm.tags = props?.movie_tags;

    function submitTrailer() {
        form.post('/admin/movies/' + props.movie.id + '/add-trailer', {
            onSuccess: () => form.reset(),
        });
    }

    function submitDownload() {
        formDownload.post('/admin/movies/' + props.movie.id + '/add-download', {
            onSuccess: () => form.reset(),
        });
    }

    function submitCast() {
        castForm.post('/admin/movies/' + props.movie.id + '/add-cast', {
            preserveState: true,
            preserveScroll: true,
        });
    }

    function submitTag() {
        tagForm.post('/admin/movies/' + props.movie.id + '/add-tag', {
            preserveState: true,
            preserveScroll: true,
        });
    }

</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>

</style>