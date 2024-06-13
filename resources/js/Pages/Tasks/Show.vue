<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Submit from "@/Pages/Tasks/Partials/Submit.vue";
import ListSubmissions from "@/Pages/Tasks/Partials/ListSubmissions.vue";

const props = defineProps({
    task: Object,
    userSubmissions: Object,
});
</script>

<template>

    <Head :title="task.title"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ task.title }}</h2>
        </template>

        <div class="bg-gray-50 flex flex-col items-center justify-center py-12">
            <div class="max-w-3xl w-full bg-white rounded-lg shadow-lg overflow-hidden p-8">

                <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ task.description }}</h2>
                <div class="flex justify-between items-center mb-6 text-gray-600">
                      <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Points: {{ task.points }}
                    </span>
                    <span class="text-sm">Solved by: {{ task.solve_count }} teams</span>
                </div>

                <div v-if="task.image_path" class="mb-6">
                    <img :src="task.image_path" alt="Task Image" class="w-full rounded-md shadow-md"/>
                </div>

                <Submit :task="task" :userSubmissions="userSubmissions" class="mb-8"/>

                <div>
                    <ListSubmissions :task="task" :userSubmissions="userSubmissions"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
