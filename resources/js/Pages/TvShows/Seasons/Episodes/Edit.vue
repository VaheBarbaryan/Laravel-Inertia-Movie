<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ tvShow ? tvShow.name : '' }} - {{ season ? season.name : '' }} - {{ episode ? episode.name : '' }}
                Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 justify-end">
                        <Link :href="route('admin.episodes.index', [tvShow.id, season.id])"
                              class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            Episodes Index
                        </Link>
                    </div>
                    <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white">
                        <form @submit.prevent="updateEpisode" novalidate>
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
                                <InputLabel for="overview" value="Overview"/>
                                <TextInput
                                        id="overview"
                                        v-model="form.overview"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.overview ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
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
    import AdminLayout from "@/Layouts/AdminLayout.vue";
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
        tvShow: Object,
        season: Object,
        episode: Object,
    });

    const form = useForm({
        name: props.episode.name,
        overview: props.episode.overview,
        is_public: props.episode.is_public,
    });

    function updateEpisode() {
        form.put(`/admin/tv-shows/${props.tvShow.id}/seasons/${props.season.id}/episodes/${props.episode.id}`);
    }

</script>

<style scoped>

</style>