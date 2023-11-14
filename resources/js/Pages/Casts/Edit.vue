<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Casts Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 justify-end">
                        <Link :href="route('admin.casts.index')"
                              class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            Casts Index
                        </Link>
                    </div>
                    <div class="w-full mb-8 p-6 overflow-hidden rounded-lg shadow-lg bg-white">
                        <form @submit.prevent="updateCast" novalidate>
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
                                <InputLabel for="place_of_birth" value="Place of Birth"/>
                                <TextInput
                                        id="place_of_birth"
                                        v-model="form.place_of_birth"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.place_of_birth ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.place_of_birth"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="biography" value="Biography"/>
                                <textarea
                                        id="biography"
                                        v-model="form.biography"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :style="form.errors.biography ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                        required
                                        autocomplete="username"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.biography"/>
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

    const props = defineProps({
        cast: Object,
    });

    const form = useForm({
        name: props.cast.name,
        biography: props.cast.biography,
        place_of_birth: props.cast.place_of_birth,
        poster_path: props.cast.poster_path,
    });

    function updateCast() {
        form.put('/admin/casts/' + props.cast.id);
    }

</script>

<style scoped>

</style>