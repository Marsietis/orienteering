<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
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
            <div class="flex items-center space-x-4">
                <Link :href="route('dashboard')" class="flex-shrink-0">
                    <button class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Atgal / Back
                    </button>
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ task.title }}</h2>
            </div>
        </template>

        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-4xl mx-auto px-4 space-y-6">
                
                <!-- Task Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <!-- Task Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ task.points }} Taškai / Points
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                </svg>
                                Išsprendė {{ task.solve_count }} komandos / Solved by {{ task.solve_count }} teams
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Užduoties aprašymas / Task Description</h3>
                            <p class="text-gray-700 leading-relaxed">{{ task.description }}</p>
                        </div>

                        <!-- Task Image -->
                        <div v-if="task.image_path" class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Pavyzdžio nuotrauka / Reference Image</h3>
                            <div class="relative group">
                                <img :src="task.image_path" 
                                     alt="Užduoties pavyzdys / Task Reference" 
                                     class="w-full max-w-2xl mx-auto rounded-lg shadow-md border border-gray-200 cursor-zoom-in transition-transform duration-200 hover:scale-[1.02]"/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Solution Card -->
                <Submit :task="task" :userSubmissions="userSubmissions"/>

                <!-- Submissions History -->
                <ListSubmissions :task="task" :userSubmissions="userSubmissions"/>
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>
