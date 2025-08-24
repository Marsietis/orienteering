<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import CountdownTimer from '@/Components/CountdownTimer.vue';
import {ref} from 'vue';
import {router} from '@inertiajs/vue3';

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

const handleEventStarted = () => {
    router.reload();
};

const handleEventEnded = () => {
    router.reload();
};

// Helper function for Lithuanian point endings (without number)
const getPointsText = (points) => {
    if (points % 10 === 1 && points % 100 !== 11) {
        return `Taškas`;
    } else if ([2, 3, 4, 5, 6, 7, 8, 9].includes(points % 10) && ![12, 13, 14, 15, 16, 17, 18, 19].includes(points % 100)) {
        return `Taškai`;
    } else {
        return `Taškų`;
    }
};

// Helper function for Lithuanian task count endings (without number)
const getTasksText = (count) => {
    if (count % 10 === 1 && count % 100 !== 11) {
        return `Išspręsta užduotis`;
    } else if ([2, 3, 4, 5, 6, 7, 8, 9].includes(count % 10) && ![12, 13, 14, 15, 16, 17, 18, 19].includes(count % 100)) {
        return `Išspręstos užduotys`;
    } else {
        return `Išspręsta užduočių`;
    }
};
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold text-center text-gray-900 leading-tight">
                VU SA KnF Orientacinės varžybos / VU SR KnF Orienteering Competition
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Competition Timer Card -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 mb-8">
                    <CountdownTimer 
                        :eventEndDateTime="eventEndDateTime" 
                        @event-started="handleEventStarted"
                        @event-ended="handleEventEnded"
                        class="py-6"
                    />
                </div>

                <!-- User Stats Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ user.name }}</h1>
                            <p class="text-gray-600">Komanda / Team</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="text-center p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg">
                                <div class="flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <div class="text-3xl font-bold text-indigo-600">{{ user.points }}</div>
                                </div>
                                <div class="text-sm text-gray-700 font-medium">{{ getPointsText(user.points) }} / Points</div>
                            </div>
                            <div class="text-center p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg">
                                <div class="flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-3xl font-bold text-green-600">{{ solvedTasksCount }}</div>
                                </div>
                                <div class="text-sm text-gray-700 font-medium">{{ getTasksText(solvedTasksCount) }} / Tasks Solved</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refresh Button -->
                <div class="text-center mb-8">
                    <Link :href="route('dashboard')"
                          class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md"
                          :class="{'opacity-50 cursor-not-allowed': isLoading}"
                          :disabled="isLoading"
                          @click="refreshDashboard"
                    >
                        <span v-if="isLoading" class="animate-spin mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </span>
                        <span v-else class="mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </span>
                        <span>{{ isLoading ? 'Atnaujinama... / Refreshing...' : 'Atnaujinti / Refresh' }}</span>
                    </Link>
                </div>

                <!-- Tasks Section -->
                <div v-if="tasks">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Užduotys / Tasks</h2>
                        <p class="text-gray-600">Spustelėkite užduotį norėdami ją atlikti / Click on a task to complete it</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <div v-for="task in tasks" :key="task.id"
                             class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <Link :href="route('tasks.show', { id: task.id })" class="block p-6 h-full">
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 hover:text-blue-600 transition-colors">
                                        {{ task.title }}
                                    </h3>
                                    
                                    <div class="flex justify-center">
                                        <span v-if="task.submissions.length > 0"
                                              class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium"
                                              :class="{
                                                  'bg-green-100 text-green-800': task.submissions[0].status === 'approved',
                                                  'bg-yellow-100 text-yellow-800': task.submissions[0].status === 'pending',
                                                  'bg-red-100 text-red-800': task.submissions[0].status === 'rejected'
                                              }">
                                            <span v-if="task.submissions[0].status === 'approved'" class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Patvirtinta / Approved
                                            </span>
                                            <span v-else-if="task.submissions[0].status === 'pending'" class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Laukiama / Pending
                                            </span>
                                            <span v-else-if="task.submissions[0].status === 'rejected'" class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Atmesta / Rejected
                                            </span>
                                        </span>
                                        <span v-else class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            Neišspręsta / Not Solved
                                        </span>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
