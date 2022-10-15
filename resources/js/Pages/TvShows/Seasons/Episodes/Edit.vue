<template>
    <admin-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Episode Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2">
                        <Link :href="route('admin.episodes.index', [tvShow.id, season.id])"
                            class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-700 text-white"
                        >
                            Episode Index
                        </Link>
                    </div>

                    <div
                        class="w-full sm:max-w-md p-6 mb-8 bg-white overflow-hidden rounded-lg shadow-lg"
                    >
                        <form @submit.prevent="submitEpisode">
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
    tvShow: Object,
    season: Object,
    episode: Object,
});

const form = useForm({
    name: props.episode.name,
    overview: props.episode.overview,
    is_public: props.episode.is_public ? true : false,
});

function submitEpisode() {
    form.put(`/admin/tv-shows/${props.tvShow.id}/seasons/${props.season.id}/episodes/${props.episode.id}`);
}

</script>
