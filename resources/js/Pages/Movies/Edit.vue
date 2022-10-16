<template>
    <admin-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2">
                        <Link :href="route('admin.movies.index')"
                            class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-700 text-white"
                        >
                            Movie Index
                        </Link>
                    </div>

                    <div
                        class="w-full sm:max-w-md p-6 mb-8 bg-white overflow-hidden rounded-lg shadow-lg"
                    >
                        <form @submit.prevent="submitMovie">
                            <div>
                                <InputLabel for="title" value="title" />
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

                            <div>
                                <InputLabel for="runtime" value="Runtime" />
                                <TextInput
                                    id="runtime"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.runtime"
                                    autofocus
                                    autocomplete="runtime"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.runtime">
                                    {{ form.errors.runtime }}
                                </div>
                            </div>

                            <div>
                                <InputLabel for="lang" value="Language" />
                                <TextInput
                                    id="lang"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.lang"
                                    autofocus
                                    autocomplete="lang"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.lang">
                                    {{ form.errors.lang }}
                                </div>
                            </div>

                            <div>
                                <InputLabel for="video_format" value="Format" />
                                <TextInput
                                    id="video_format"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.video_format"
                                    autofocus
                                    autocomplete="video_format"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.video_format">
                                    {{ form.errors.video_format }}
                                </div>
                            </div>

                            <div>
                                <InputLabel for="rating" value="Rating" />
                                <TextInput
                                    id="rating"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.rating"
                                    autofocus
                                    autocomplete="rating"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.rating">
                                    {{ form.errors.rating }}
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

                            <div class="mt-4">
                                <InputLabel for="backdrop_path" value="Backdrop" />
                                <TextInput
                                    id="backdrop_path"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.backdrop_path"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.backdrop_path">
                                    {{ form.errors.backdrop_path }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="overview" value="Overview" />
                                <TextInput
                                    id="overview"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.overview"
                                />
                                <div class="text-sm text-red-400" v-if="form.errors.overview">
                                    {{ form.errors.overview }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="flex items-center">
                                    <Checkbox v-model:checked="form.is_public" name="is_public" />
                                    <span class="ml-2 text-sm text-gray-600">Public</span>
                                </label>
                                <div class="text-sm text-red-400" v-if="form.errors.is_public">
                                    {{ form.errors.is_public }}
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
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    movie: Object,
});

const form = useForm({
    title: props.movie.title,
    poster_path: props.movie.poster_path,
    video_format: props.movie.video_format,
    runtime: props.movie.runtime,
    rating: props.movie.rating,
    backdrop_path: props.movie.backdrop_path,
    overview: props.movie.overview,
    is_public: props.movie.is_public ? true : false,
    lang: props.movie.lang,
});

function submitMovie() {
    form.put(`/admin/movies/${props.movie.id}`);
}

</script>
