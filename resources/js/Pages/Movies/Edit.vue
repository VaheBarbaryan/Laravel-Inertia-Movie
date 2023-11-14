<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Edit
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
                        <form @submit.prevent="updateMovie" novalidate>
                            <div>
                                <InputLabel for="title" value="Title"/>
                                <TextInput
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.title ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.title"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="runtime" value="Runtime"/>
                                <TextInput
                                        id="runtime"
                                        v-model="form.runtime"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.runtime ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.runtime"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="lang" value="Language"/>
                                <TextInput
                                        id="lang"
                                        v-model="form.lang"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.lang ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.lang"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="video_format" value="Format"/>
                                <TextInput
                                        id="video_format"
                                        v-model="form.video_format"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.video_format ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.video_format"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="rating" value="Rating"/>
                                <TextInput
                                        id="rating"
                                        v-model="form.rating"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.rating ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.rating"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="poster_path" value="Poster"/>
                                <TextInput
                                        id="poster_path"
                                        v-model="form.poster_path"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.poster_path ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.poster_path"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="backdrop_path" value="Backdrop"/>
                                <TextInput
                                        id="backdrop_path"
                                        v-model="form.backdrop_path"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.backdrop_path ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.backdrop_path"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="overview" value="Overview"/>
                                <TextInput
                                        id="overview"
                                        v-model="form.overview"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.overview ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autofocus
                                        autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.overview"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="is_public" value="Public"/>
                                <FormSelect
                                        :style="form.errors.is_public ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        id="is_public" v-model="form.is_public">
                                    <option value="0">Unpublished</option>
                                    <option value="1">Published</option>
                                </FormSelect>
                                <InputError class="mt-2" :message="form.errors.is_public"/>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="adult" value="Adult"/>
                                <FormSelect
                                        :style="form.errors.adult ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        id="adult" v-model="form.adult">
                                    <option value="0">Not Adult</option>
                                    <option value="1">Adult</option>
                                </FormSelect>
                                <InputError class="mt-2" :message="form.errors.is_public"/>
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
                                    Update
                                </PrimaryButton>
                            </div>
                        </form>
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

    const props = defineProps({
        movie: Object,
    });

    const form = useForm({
        title: props.movie.title,
        runtime: props.movie.runtime,
        lang: props.movie.lang,
        video_format: props.movie.video_format,
        rating: props.movie.rating,
        adult: props.movie.adult,
        poster_path: props.movie.poster_path,
        backdrop_path: props.movie.backdrop_path,
        overview: props.movie.overview,
        is_public: props.movie.is_public,
    });

    function updateMovie() {
        form.put('/admin/movies/' + props.movie.id);
    }

</script>

<style scoped>

</style>