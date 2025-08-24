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

const getRankMedal = (index) => {
    if (index === 0) return '🥇';
    if (index === 1) return '🥈';
    if (index === 2) return '🥉';
    return '';
};

const getRankClass = (index) => {
    if (index === 0) return 'bg-gradient-to-r from-yellow-100 to-amber-100 border border-yellow-200';
    if (index === 1) return 'bg-gradient-to-r from-gray-100 to-slate-100 border border-gray-200';
    if (index === 2) return 'bg-gradient-to-r from-orange-100 to-amber-100 border border-orange-200';
    return 'bg-white border border-gray-200';
};
</script>


<template>
    <Head title="Rezultatų lentelė / Leaderboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold text-center text-gray-900 leading-tight">
                VU SA KnF Rezultatų lentelė / VU SR KnF Leaderboard
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Page Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Rezultatų lentelė / Leaderboard</h1>
                    <p class="text-gray-600">Komandų reitingas pagal surinktuosius taškus / Team ranking by points earned</p>
                </div>

                <!-- Refresh Button -->
                <div class="text-center mb-8">
                    <Link :href="route('leaderboard')"
                          class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md"
                          :class="{'opacity-50 cursor-not-allowed': isLoading}"
                          :disabled="isLoading"
                          @click="refreshLeaderboard"
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

                <!-- Mobile Card Layout -->
                <div class="block md:hidden space-y-4">
                    <div v-for="(user, index) in users" :key="user.id"
                         class="rounded-xl shadow-sm transition-all duration-200 hover:shadow-md"
                         :class="getRankClass(index)"
                    >
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 text-lg font-bold">
                                        {{ index + 1 }}
                                    </div>
                                    <div class="text-2xl">{{ getRankMedal(index) }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-indigo-600">{{ user.points }}</div>
                                    <div class="text-sm text-gray-600">taškai / points</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">{{ user.name }}</h3>
                                <p class="text-sm text-gray-600">komanda / team</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Paskutinė užduotis / Last task:</span>
                                {{ DateTime.fromISO(user.updated_at).toRelative() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table Layout -->
                <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                    Vieta / Rank
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                    Komanda / Team
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                    Taškai / Points
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                    Paskutinė užduotis / Last Task
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(user, index) in users" :key="user.id" 
                                class="hover:bg-gray-50 transition-colors duration-200"
                                :class="{
                                    'bg-gradient-to-r from-yellow-50 to-amber-50': index === 0,
                                    'bg-gradient-to-r from-gray-50 to-slate-50': index === 1,
                                    'bg-gradient-to-r from-orange-50 to-amber-50': index === 2
                                }"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-sm font-bold">
                                            {{ index + 1 }}
                                        </div>
                                        <span class="text-xl">{{ getRankMedal(index) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ user.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-indigo-600">{{ user.points }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ DateTime.fromISO(user.updated_at).toRelative() }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="!users || users.length === 0" class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Rezultatų nėra / No Results</h3>
                    <p class="text-gray-600">Dar nėra komandų, kurios būtų sprendusios užduotis / No teams have solved tasks yet</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
