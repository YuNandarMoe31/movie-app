<template>
    <Link :href="link"
        class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-700 text-white"
    >
        <slot />
    </Link>
</template>

<script setup>
import { defineProps } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    link: {
        type: String,
        required: true
    }
})

</script>