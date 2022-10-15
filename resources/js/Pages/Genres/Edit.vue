<template>
    <admin-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Genres Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2">
                        <Link :href="route('admin.genres.index')"
                            class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-700 text-white"
                        >
                            Genre Index
                        </Link>
                    </div>

                    <div
                        class="w-full sm:max-w-md p-6 mb-8 bg-white overflow-hidden rounded-lg shadow-lg"
                    >
                        <form @submit.prevent="submitGenre">
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    autofocus
                                    autocomplete="title"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.title">
                                    {{ form.errors.title }}
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button
                                    type="submit"
                                     class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </admin-layout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, watch, defineProps } from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    genre: Object,
});

const form = useForm({
    title: props.genre.title,
});

function submitGenre() {
    form.put('/admin/genres/' + props.genre.id);
}

</script>
