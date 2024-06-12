<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';

const props = defineProps({
    tasks: Array,
    solvedTasksCount: Number,
    user: Object,
});
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="flex flex-col sm:flex-row items-center justify-center p-6 text-center sm:text-left">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-black mb-2 sm:mb-0">{{ user.name }}</h1>
                        <div class="sm:ml-8">
                            <div class="font-semibold text-gray-800 mb-1">Points: <span
                                class="text-indigo-500">{{ user.points }}</span></div>
                            <div class="font-semibold text-gray-800">Tasks Solved: <span
                                class="text-green-500">{{ solvedTasksCount }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-8">
                        <div v-for="task in tasks" :key="task.id"
                             class="task-card bg-white rounded-lg shadow-2xl overflow-hidden transition-transform duration-300 hover:scale-105">
                            <Link :href="route('tasks.show', { id: task.id })">
                                <div
                                    class="task-content p-6 text-black text-2xl text-center font-bold hover:text-blue-500 border-b-2 border-transparent border-blue-200 hover:border-blue-500">
                                    {{ task.title }}
                                </div>
                            </Link>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
