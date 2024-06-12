<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import {DateTime} from "luxon";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    users: Array,
    currentUser: Object,
});
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
                        <Link :href="route('leaderboard')">
                            <SecondaryButton class="mt-3 mb-5">Refresh</SecondaryButton>
                        </Link>
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
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Last Task
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
    </AuthenticatedLayout>
</template>
