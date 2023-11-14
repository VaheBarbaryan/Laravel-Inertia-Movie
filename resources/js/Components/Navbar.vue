<template>
    <div class="w-full text-gray-700 bg-white dark:text-gray-200 dark:bg-gray-800">
        <div class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
            <div class="p-4 flex flex-row items-center justify-between space-x-2">
                <Link href="/"
                      class="mr-2 text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark:text-white focus:outline-none focus:shadow-outline">
                    Movie
                    App
                </Link>
                <SearchModal class="w-40 md:w-72"/>
                <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline"
                        @click="openMobileMenu = !openMobileMenu">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path v-show="!openMobileMenu" fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                              clip-rule="evenodd"></path>
                        <path v-show="openMobileMenu" fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <Link v-if="$page.props.is_admin" :href="route('admin.index')"
                  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">
                Admin Panel
            </Link>
            <nav :class="{'flex': openMobileMenu, 'hidden': !openMobileMenu}"
                 class="flex-col flex-grow pb-4 md:pb-0 md:flex md:justify-end md:flex-row">

                <Link class="bg-transparent px-4 py-2 mt-2 text-sm font-semibold rounded-lg dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                      :href="route('movies.index')">Movies
                </Link>
                <Link class="bg-transparent px-4 py-2 mt-2 text-sm font-semibold rounded-lg dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                      :href="route('tv-shows.index')">Tv Shows
                </Link>
                <Link class="bg-transparent px-4 py-2 mt-2 text-sm font-semibold rounded-lg dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                      :href="route('casts.index')">Casts
                </Link>
                <!--                <div class="relative">-->
                <!--                    <button @click="open = !open"-->
                <!--                            class="bg-transparent dark:bg-transparent flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left rounded-lg dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">-->
                <!--                        <span>Genres</span>-->
                <!--                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}"-->
                <!--                             class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">-->
                <!--                            <path fill-rule="evenodd"-->
                <!--                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"-->
                <!--                                  clip-rule="evenodd"></path>-->
                <!--                        </svg>-->
                <!--                    </button>-->
                <!--                    <div v-show="open" class="absolute z-[100] right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-96">-->
                <!--                        <div class="px-2 py-2 bg-white rounded-md shadow dark:bg-gray-800 flex flex-wrap">-->
                <!--                            <Link v-for="genre in $page.props.genres" :key="genre.id"-->
                <!--                                  class="text-sm p-2 m-2 font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"-->
                <!--                                  :href="route('genres.show',genre.slug)">{{ genre.title }}-->
                <!--                            </Link>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <Dropdown/>
                <Link v-if="!$page.props.user"
                      class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4"
                      :href="route('login')">Sign in
                </Link>
                <Link v-if="!$page.props.user"
                      class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4"
                      :href="route('register')">Sign up
                </Link>
                <div v-if="$page.props.user && !$page.props.is_admin" class="relative">
                    <button @click="dropdownOpen = ! dropdownOpen" type="button" class="ml-4">
                        <span class="tooltip_hover bg-indigo-600">{{ $page.props.user.name.trim()[0] }}</span>
                    </button>
                    <div v-show="dropdownOpen" @click="dropdownOpen = false"
                         class="fixed inset-0 h-full w-full" style="z-index: 1000;"></div>

                    <div v-show="dropdownOpen" style="z-index: 1000;"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl">
                        <p class="text-center p-2 font-bold">{{ $page.props.user.name }}</p>
                        <Link :href="route('profile')"
                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Edit
                            Profile
                        </Link>
                        <Link :href="route('watchlist')"
                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
                            Watchlist
                        </Link>
                        <Link :href="route('logout')" method="POST"
                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
                            Log out
                        </Link>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</template>

<script setup>
    import {ref} from 'vue'
    import {Link} from '@inertiajs/vue3'
    import Dropdown from './MyDropdown.vue'
    import SearchModal from "./SearchModal.vue"

    const open = ref(false);
    const openMobileMenu = ref(false);
    const dropdownOpen = ref(false);
</script>

<style scoped>
    .tooltip_hover {
        width: 32px;
        height: 32px;
        text-align: center;
        text-transform: uppercase;
        border-radius: 50%;
        color: #ffffff;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>