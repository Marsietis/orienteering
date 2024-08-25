<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import CountdownTimer from '@/Components/CountdownTimer.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {ref} from 'vue';

const props = defineProps({
    tasks: Array,
    solvedTasksCount: Number,
    user: Object,
    eventEndDateTime: String,
});

const isLoading = ref(false);

const refreshDashboard = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 20000);
};

const getStatusClass = (status) => ({
    'approved': 'bg-green-500',
    'pending': 'bg-yellow-500',
    'rejected': 'bg-red-500',
}[status] || 'bg-gray-500');
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <CountdownTimer :eventEndDateTime="eventEndDateTime" class="pt-4"/>
                    <div class="flex flex-col sm:flex-row items-center justify-center p-6 text-center sm:text-left">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2 sm:mb-0">{{ user.name }}</h1>
                        <div class="sm:ml-8 mt-2 sm:mt-0">
                            <div class="font-semibold text-gray-800 mb-1">Points:
                                <span class="text-indigo-500">{{ user.points }}</span>
                            </div>
                            <div class="font-semibold text-gray-800">Tasks Solved:
                                <span class="text-green-500">{{ solvedTasksCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <Link :href="route('dashboard')"
                  class="mt-4 relative flex items-center bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 focus:ring focus:ring-blue-200 rounded-xl text-2xl px-4 py-2"
                  :class="{'opacity-50 cursor-not-allowed': isLoading}"
                  :disabled="isLoading"
                  @click="refreshDashboard"
            >
                <!-- Loading spinner icon with spinning animation -->
        <span v-if="isLoading" class="animate-spin mr-2">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.06189 13C4.02104 12.6724 4 12.3387 4 12C4 7.58172 7.58172 4 12 4C14.5006 4 16.7332 5.14727 18.2002 6.94416M19.9381 11C19.979 11.3276 20 11.6613 20 12C20 16.4183 16.4183 20 12 20C9.61061 20 7.46589 18.9525 6 17.2916M9 17H6V17.2916M18.2002 4V6.94416M18.2002 6.94416V6.99993L15.2002 7M6 20V17.2916"/>
            </svg>
        </span>

                <!-- Static refresh icon -->
        <span v-else class="mr-2">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.06189 13C4.02104 12.6724 4 12.3387 4 12C4 7.58172 7.58172 4 12 4C14.5006 4 16.7332 5.14727 18.2002 6.94416M19.9381 11C19.979 11.3276 20 11.6613 20 12C20 16.4183 16.4183 20 12 20C9.61061 20 7.46589 18.9525 6 17.2916M9 17H6V17.2916M18.2002 4V6.94416M18.2002 6.94416V6.99993L15.2002 7M6 20V17.2916"/>
            </svg>
        </span>

                <span>{{ isLoading ? 'Refreshing...' : 'Refresh' }}</span>
            </Link>
        </div>



        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div v-for="task in tasks" :key="task.id"
                         class="task-card bg-white rounded-lg shadow-xl overflow-hidden transform transition duration-300 hover:scale-105">
                        <Link :href="route('tasks.show', { id: task.id })">
                            <div
                                class="task-content p-6 text-gray-900 text-xl text-center font-bold hover:text-blue-500">
                                {{ task.title }}
                                <span v-if="task.submissions.length > 0"
                                      class="text-sm text-white rounded-full px-3 py-1 mt-2 inline-block capitalize"
                                      :class="getStatusClass(task.submissions[0].status)">
                                    {{ task.submissions[0].status }}
                                </span>
                                <div v-else
                                     class="text-sm bg-gray-500 text-white rounded-full px-3 py-1 mt-2 inline-block capitalize">
                                    Not Solved
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
