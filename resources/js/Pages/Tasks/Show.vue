<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

const props = defineProps({
    task: Object,
});
</script>

<template>

    <Head :title="task.title"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ task.title }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>{{ task.description }}</p>
                        <p>Points: {{ task.points }}</p>
                        <p>Solved by: {{ task.solve_count }}</p>
                        <div v-if="task.image_path">
                            <img :src="task.image_path" alt="Task Image" class="max-w-full h-auto mt-4"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
