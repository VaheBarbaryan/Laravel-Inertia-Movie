<template>
    <FrontLayout>
        <main class="my-2">
            <div class="max-w-6xl mx-auto m-4 p-2">
                <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-indigo-600">Change Email</h1>
                <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-4 rounded">
                    <form @submit.prevent="changeEmail" novalidate>
                        <div>
                            <InputLabel for="password" value="Password"/>
                            <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    :style="form.errors.password ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                                    autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.password"/>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="new_email" value="New Email Address"/>
                            <TextInput
                                    id="new_email"
                                    v-model="form.new_email"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :style="form.errors.new_email ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                                    autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.new_email"/>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="confirm_new_email" value="Confirm New Email Address"/>
                            <TextInput
                                    id="confirm_new_email"
                                    v-model="form.confirm_new_email"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :style="form.errors.confirm_new_email ? {'borderColor': 'red'} : {'borderColor': 'gray'}"
                                    required
                                    autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.confirm_new_email"/>
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

    const form =  useForm({
        password: '',
        new_email: '',
        confirm_new_email: '',
    })

    function changeEmail() {
        form.post('/profile/change-email');
    }
</script>

<style scoped>

</style>