<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tv Show Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 justify-end">
                        <Link :href="route('admin.tv-shows.index')"
                              class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            Tv Shows Index
                        </Link>
                    </div>
                    <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white">
                        <form @submit.prevent="updateTvShow" novalidate>
                            <div>
                                <InputLabel for="name" value="Name" />
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
                                <InputLabel for="poster_path" value="Poster Path"/>
                                <TextInput
                                        id="poster_path"
                                        v-model="form.poster_path"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.poster_path ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.poster_path"/>
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
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.rating"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="rate_count" value="Rate Count"/>
                                <TextInput
                                        id="rate_count"
                                        v-model="form.rate_count"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.rate_count ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.rate_count"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="episode_run_time" value="Episode Run Time"/>
                                <TextInput
                                        id="episode_run_time"
                                        v-model="form.episode_run_time"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.episode_run_time ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.episode_run_time"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="number_of_episodes" value="Number of episodes"/>
                                <TextInput
                                        id="number_of_episodes"
                                        v-model="form.number_of_episodes"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.number_of_episodes ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.number_of_episodes"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="number_of_seasons" value="Number of seasons"/>
                                <TextInput
                                        id="number_of_seasons"
                                        v-model="form.number_of_seasons"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.number_of_seasons ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.number_of_seasons"/>
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
    import MyCheckbox from '@/Components/MyCheckbox.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import FormSelect from '@/Components/FormSelect.vue';

    const props = defineProps({
        tvShow: Object,
    });

    const form = useForm({
        name: props.tvShow.name,
        rating: props.tvShow.rating,
        rate_count: props.tvShow.rate_count,
        adult: props.tvShow.adult,
        episode_run_time: props.tvShow.episode_run_time,
        number_of_episodes: props.tvShow.number_of_episodes,
        number_of_seasons: props.tvShow.number_of_seasons,
        poster_path: props.tvShow.poster_path,
    });

    function updateTvShow() {
        form.put('/admin/tv-shows/' + props.tvShow.id);
    }

</script>

<style scoped>

</style>