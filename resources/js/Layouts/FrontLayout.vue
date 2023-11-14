<script setup>
    import {ref, defineProps, onMounted} from 'vue';
    import {Head, Link, router} from '@inertiajs/vue3';
    import Banner from '@/Components/Banner.vue';
    import Navbar from '@/Components/Navbar.vue';
    import Footer from '@/Components/Footer.vue';

    defineProps({
        title: String,
    });

    const showingNavigationDropdown = ref(false);

    import { InertiaProgress } from '@inertiajs/progress'
    InertiaProgress.init();

    const switchToTeam = (team) => {
        router.put(route('current-team.update'), {
            team_id: team.id,
        }, {
            preserveState: false,
        });
    };

    const logout = () => {
        router.post(route('logout'));
    };
</script>

<template>
    <div>
        <Banner/>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <Navbar/>
            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
        <Footer/>
    </div>
</template>
