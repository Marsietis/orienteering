<script setup>
import {DateTime} from "luxon";

defineProps({
    userSubmissions: Object,
});
</script>

<template>
    <div class="mt-8">
        <h2 v-if="userSubmissions.length > 0" class="text-2xl font-semibold mb-4">Your Submissions</h2>
        <div v-if="userSubmissions.length > 0">
            <div v-for="submission in userSubmissions" :key="submission.id"
                 class="bg-white rounded-lg p-6 mb-4 shadow-md flex flex-col md:flex-row">

                <div class="flex-shrink-0 w-full md:w-48 md:mr-6 mb-4 md:mb-0">
                    <img :src="submission.image_path" alt="Submission Image" class="w-full h-auto rounded-lg"/>
                </div>

                <div class="flex-grow">
                    <h1 class="text-black text-xl mb-2">Status:
                        <span class="font-semibold uppercase" :class="{
                    'text-green-600': submission.status === 'approved',
                    'text-red-600': submission.status === 'rejected',
                    'text-yellow-600': submission.status === 'pending'
                }">
                    {{ submission.status }}

                </span>
                        <div class="text-lg text-gray-500">Submitted {{ DateTime.fromISO(submission.created_at).toRelative() }}</div>
                    </h1>
                    <div v-if="submission.comments">
                        <span class="">Comment:</span>
                        <div class="text-gray-800 p-4 mb-10 border-l-4 border-gray-300 bg-gray-200">
                            {{ submission.comments }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
