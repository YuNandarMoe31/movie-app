<template>
    <admin-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Attach
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
                        <div class="flex space-x-2">
                            <div v-for="trailer in trailers" :key="trailer.id">
                                 <Link
                                    class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded"
                                    :href="route('admin.trailers.destroy', trailer.id)"
                                    method="delete"
                                    as="button"
                                    type="button"
                                    >
                                    {{ trailer.name }}
                                </Link>
                            </div>
                        </div>
                        <form @submit.prevent="submitTrailer">
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
                                <InputLabel for="embed_html" value="Embed" />
                                <textarea
                                    id="embed_html"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.embed_html"
                                ></textarea>
                                <div class="text-sm text-red-400" v-if="form.errors.embed_html">
                                    {{ form.errors.embed_html }}
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button
                                    type="submit"
                                     class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    add trailer
                                </button>
                            </div>
                        </form>
                    </div>

                    <div
                        class="w-full sm:max-w-md p-6 mb-8 bg-white rounded-lg shadow-lg"
                    >
                        <div>
                            <div class="flex">
                                <div
                                    class="m-2 p-1 text-xs"
                                    v-for="mc in movieCasts"
                                    :key="mc.id"
                                    >
                                    {{ mc.name }}
                                </div>
                            </div>
                            <form @submit.prevent="addCast">
                                <multiselect
                                    v-model="castForm.casts"
                                    :options="casts"
                                    :multiple="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    placeholder="Add Casts"
                                    label="name"
                                    track-by="name"
                                    >
                                </multiselect> 
                                <div class="mt-2">
                                    <button                                     type="submit"
                                     class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded"
                                    >add casts
                                    </button>
                                </div>  
                            </form>                     
                        </div>
                    </div>

                    <div
                        class="w-full sm:max-w-md p-6 mb-8 bg-white rounded-lg shadow-lg"
                    >
                        <div>
                            <div class="flex">
                                <div
                                    class="m-2 p-1 text-xs"
                                    v-for="mt in movieTags"
                                    :key="mt.id"
                                    >
                                    {{ mt.tag_name }}
                                </div>
                            </div>
                            <form @submit.prevent="addTag">
                                <multiselect
                                    v-model="tagForm.tags"
                                    :options="tags"
                                    :multiple="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    placeholder="Add tags"
                                    label="tag_name"
                                    track-by="tag_name"
                                    >
                                </multiselect> 
                                <div class="mt-2">
                                    <button type="submit"
                                     class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded"
                                    >add tags
                                    </button>
                                </div>  
                            </form>                     
                        </div>
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
import Multiselect from 'vue-multiselect'

const props = defineProps({
    movie: Object,
    trailers: Array,
    casts: Array,
    tags: Array,
    movieTags: Array,
    movieCasts: Array,
});

const form = useForm({
    name: "",
    embed_html: "",
});

const castForm = useForm({
    casts: props.movieCasts,
});

const tagForm = useForm({
    tags: props.movieTags,
});

function submitTrailer() {
    form.post(`/admin/movies/${props.movie.id}/add-trailer`, {
        onSuccess: () => from.reset(),
    });
}

function addCast() {
    castForm.post(`/admin/movies/${props.movie.id}/add-casts`, {
        preserveState: true,
        preserveScroll: true,
    });
}

function addTag() {
    tagForm.post(`/admin/movies/${props.movie.id}/add-tags`, {
        preserveState: true,
        preserveScroll: true,
    });
}

</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

