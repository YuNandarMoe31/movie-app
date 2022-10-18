<script setup>

import Footer from '../Components/Footer.vue'
import Navbar from '@/Components/Navbar.vue'
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    title: String,
});

</script>

<template>
    <div>
        <Head :title="title" />

        <!-- Nav -->
        <Navbar />

        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
                <slot />
            </main>           
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>
