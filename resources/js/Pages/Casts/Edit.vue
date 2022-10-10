<template>
    <admin-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Casts Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2">
                        <Link
                            class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-700 text-white"
                        >
                            Cast Index
                        </Link>
                    </div>

                    <div
                        class="w-full sm:max-w-md p-6 mb-8 bg-white overflow-hidden rounded-lg shadow-lg"
                    >
                        <form @submit.prevent="submitCast">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    autofocus
                                    autocomplete="name"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.name">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="poster_path" value="Poster" />
                                <TextInput
                                    id="poster_path"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.poster_path"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.poster_path">
                                    {{ form.errors.poster_path }}
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
    cast: Object,
});

const form = useForm({
    name: props.cast.name,
    poster_path: props.cast.poster_path
});

function submitCast() {
    form.put('/admin/casts/' + props.cast.id);
}

</script>
