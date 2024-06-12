<script setup>
defineProps({
    userSubmissions: Object,
});
</script>

<template>
    <div class="mt-4">
        <div v-if="userSubmissions.length > 0">
            <ul>
                <li v-for="submission in userSubmissions" :key="submission.id" class="mb-2">
                    Id: {{ submission.id }}
                        Submission status: {{ submission.status }}
                    <img :src="submission.image_path" alt="Submission Image" class="max-w-full h-auto mt-4"/>
                    Comments: {{ submission.comments }}
                </li>
            </ul>
        </div>
        <div v-else>
            <p>You have not submitted anything yet.</p>
        </div>
    </div>
</template>
