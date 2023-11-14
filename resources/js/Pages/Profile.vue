<template>
    <FrontLayout>
        <main class="my-2">
            <div class="max-w-6xl mx-auto m-4 p-2">
                <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-indigo-600">Edit Profile</h1>
                <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-4 rounded">
                    <form @submit.prevent="editProfile" novalidate>
                        <div>
                            <InputLabel for="first_name" value="First Name"/>
                            <TextInput
                                    id="first_name"
                                    v-model="form.first_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :style="form.errors.first_name ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                                    autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.first_name"/>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="last_name" value="Last Name"/>
                            <TextInput
                                    id="last_name"
                                    v-model="form.last_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :style="form.errors.last_name ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                                    autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.last_name"/>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="email" value="Email"/>
                            <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :style="form.errors.email ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                                    disabled
                                    readonly
                            />
                            <InputError class="mt-2" :message="form.errors.email"/>
                        </div>
                        <div class="mt-2">
                            <Link :href="route('change-email')" class="hover:underline">Change Email</Link>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="address" value="Address"/>
                            <TextInput
                                    id="address"
                                    v-model="form.address"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :style="form.errors.address ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                                    autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.address"/>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="contact_number" value="Contact Number"/>
                            <TextInput
                                    id="contact_number"
                                    v-model="form.contact_number"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :style="form.errors.contact_number ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                                    autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.contact_number"/>
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
                                Save
                            </PrimaryButton>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </FrontLayout>
</template>

<script setup>
    import FrontLayout from '@/Layouts/FrontLayout.vue'
    import {Link, router, useForm, usePage} from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import TextInput from '@/Components/TextInput.vue'

    const form = useForm({
        first_name: usePage().props.user.first_name,
        last_name: usePage().props.user.last_name,
        email: usePage().props.user.email,
        address: usePage().props.user.address,
        contact_number: usePage().props.user.contact_number,
    });

    function editProfile() {
        form.put('/profile');
    }
</script>

<style scoped>

</style>