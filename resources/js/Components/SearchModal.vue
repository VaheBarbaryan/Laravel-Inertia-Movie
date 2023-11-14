<template>
    <!--    <button v-bind="$attrs" type="button" @click="openModal"-->
    <!--            class="w-52 md:w-72 flex items-center text-sm leading-6 text-gray-400 rounded-md ring-1 ring-gray-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-gray-300 dark:bg-gray-700 dark:highlight-white/5 dark:hover:bg-gray-900">-->
    <!--        <svg-->
    <!--                width="24" height="24" fill="none" aria-hidden="true" class="mr-3 flex-none">-->
    <!--            <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
    <!--                  stroke-linejoin="round"></path>-->
    <!--            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
    <!--                    stroke-linejoin="round"></circle>-->
    <!--        </svg>-->
    <!--        Quick search...<span class="ml-auto pl-3 flex-none text-xs font-semibold">⌘K</span>-->
    <!--    </button>-->
    <button v-bind="$attrs" type="button" @click="openModal"
            class="flex items-center space-x-2 border border-slate-100 bg-slate-100 dark:border-slate-800 dark:bg-slate-800 shadow-sm px-3 py-1.5 hover:border-gray-300 focus:outline-none focus:border-gray-300 rounded-lg">
        <svg class="flex-none text-gray-400 -ml-1" width="24" height="24" fill="none" aria-hidden="true">
            <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round"></path>
            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></circle>
        </svg>
        <span class="text-sm hidden text-gray-400 md:block flex-1 text-left">Search...</span>
    </button>
    <TransitionRoot appear :show="isOpen">
        <Dialog @close="closeModal" class="fixed inset-0 top-14 z-50 flex justify-center items-start">
            <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
            >
                <div class="fixed inset-0"/>
            </TransitionChild>

            <div>
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900 dark:text-white"
                            >
                                Search Movies, Tv Shows, Casts...
                            </DialogTitle>
                            <div class="flex items-center justify-center mt-4">
                                <div class="flex border-2 rounded-md">
                                    <input @input="(e) => search(e.target.value)" type="text"
                                           class="px-4 py-2 w-80 outline-none border-transparent focus:border-transparent focus:outline-none focus:ring-0"
                                           placeholder="Search...">
                                    <div class="flex items-center justify-center px-4 border-l">
                                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-200" fill="currentColor"
                                             xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24">
                                            <path
                                                    d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div v-if="isLoading" role="status"
                                 class="space-y-8 animate-pulse md:space-y-0 md:space-x-8 md:flex md:items-center mt-4">
                                <div class="flex items-center justify-center w-full h-24 bg-gray-300 rounded sm:w-48 dark:bg-gray-700">
                                    <svg class="w-12 h-12 text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                         aria-hidden="true" fill="currentColor" viewBox="0 0 640 512">
                                        <path d="M480 80C480 35.82 515.8 0 560 0C604.2 0 640 35.82 640 80C640 124.2 604.2 160 560 160C515.8 160 480 124.2 480 80zM0 456.1C0 445.6 2.964 435.3 8.551 426.4L225.3 81.01C231.9 70.42 243.5 64 256 64C268.5 64 280.1 70.42 286.8 81.01L412.7 281.7L460.9 202.7C464.1 196.1 472.2 192 480 192C487.8 192 495 196.1 499.1 202.7L631.1 419.1C636.9 428.6 640 439.7 640 450.9C640 484.6 612.6 512 578.9 512H55.91C25.03 512 .0006 486.1 .0006 456.1L0 456.1z"/>
                                    </svg>
                                </div>
                                <div class="w-full">
                                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-24 mb-4"></div>
                                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[480px] mb-2.5"></div>
                                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[440px] mb-2.5"></div>
                                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[460px] mb-2.5"></div>
                                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px]"></div>
                                </div>
                                <span class="sr-only">Loading...</span>
                            </div>
                            <ul class="m-2" v-if="results.length > 0 && !isLoading">
                                <li v-for="result in results" :key="result.id"
                                    class="flex items-center w-full px-4 py-2 5 relative rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600">
                                    <Link class="flex space-x-2" :href="result.url">
                                        <div class="text-blue-300 hover:text-blue-500">{{ result.title }}</div>
                                        <span class="font-bold ml-2 text-black dark:text-white"> {{ result.type }}</span>
                                    </Link>
                                </li>
                            </ul>
                            <div class="mt-4" v-if="results.length === 0 && !isLoading">
                                <h1 class="text-lg text-gray-500 dark:text-gray-200 text-center">
                                    No Results...
                                </h1>
                            </div>

                            <div class="mt-4">
                                <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100  px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                                        @click="closeModal"
                                >
                                    Cancel
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
    import {ref} from 'vue'
    import {debounce} from "lodash"
    import {Link} from "@inertiajs/vue3"
    import {
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogPanel,
        DialogTitle
    } from '@headlessui/vue'

    const isOpen = ref(false)
    const isLoading = ref(false)
    const results = ref([])

    const search = debounce(async (term) => {
        isLoading.value = true
        let {data} = await axios.get('/api/search', {params: {search: term}})
        results.value = data
        isLoading.value = false
    }, 250)

    function closeModal() {
        isOpen.value = false
        isLoading.value = false
    }

    function openModal() {
        isOpen.value = true
    }
</script>

<style scoped>

</style>