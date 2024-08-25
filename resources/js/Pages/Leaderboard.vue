<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import {DateTime} from "luxon";
import {ref} from 'vue';

const props = defineProps({
    users: Array,
    currentUser: Object,
});

const isLoading = ref(false);

const refreshLeaderboard = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 2000);
};
</script>


<template>
    <Head title="Leaderboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Leaderboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-center">
                            <Link :href="route('leaderboard')"
                                  class="mt-4 relative flex items-center bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 focus:ring focus:ring-blue-200 rounded-xl px-4 py-2 mb-4 text-xl"
                                  :class="{'opacity-50 cursor-not-allowed': isLoading}"
                                  :disabled="isLoading"
                                  @click="refreshLeaderboard">
                                <span v-if="isLoading" class="animate-spin mr-2">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.06189 13C4.02104 12.6724 4 12.3387 4 12C4 7.58172 7.58172 4 12 4C14.5006 4 16.7332 5.14727 18.2002 6.94416M19.9381 11C19.979 11.3276 20 11.6613 20 12C20 16.4183 16.4183 20 12 20C9.61061 20 7.46589 18.9525 6 17.2916M9 17H6V17.2916M18.2002 4V6.94416M18.2002 6.94416V6.99993L15.2002 7M6 20V17.2916"/>
            </svg>
        </span>

                                <!-- Static refresh icon -->
                                <span v-else class="mr-2">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.06189 13C4.02104 12.6724 4 12.3387 4 12C4 7.58172 7.58172 4 12 4C14.5006 4 16.7332 5.14727 18.2002 6.94416M19.9381 11C19.979 11.3276 20 11.6613 20 12C20 16.4183 16.4183 20 12 20C9.61061 20 7.46589 18.9525 6 17.2916M9 17H6V17.2916M18.2002 4V6.94416M18.2002 6.94416V6.99993L15.2002 7M6 20V17.2916"/>
            </svg>
        </span>

                                <span>{{ isLoading ? 'Refreshing...' : 'Refresh' }}</span>
                            </Link>
                        </div>

                        <!-- Leaderboard Table -->
                        <div class="overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200 rounded-xl overflow-hidden shadow-xl">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Rank
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Team
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Points
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Last
                                        Task
                                        Solved
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                <tr v-for="(user, index) in users" :key="user.id" :class="{
          'bg-gradient-to-r from-yellow-200 to-orange-200': index === 0,  // 1st place
          'bg-gradient-to-r from-gray-200 to-gray-300': index === 1,     // 2nd place
          'bg-gradient-to-r from-orange-400 to-amber-400': index === 2, // 3rd place
          'bg-gray-50': index % 2 === 1 && index > 2,
          'bg-white': index % 2 === 0 && index > 2,
          'hover:bg-blue-100': true  // Add a hover effect for engagement
        }">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                        {{ index + 1 }}
                                        <span v-if="index < 3">🏆</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">{{ user.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">{{ user.points }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ DateTime.fromISO(user.updated_at).toRelative() }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
