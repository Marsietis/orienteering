<script setup>
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const imageInput = ref(null);
const props = defineProps({
    task: Object,
    userSubmissions: Object,
});

const form = useForm({
    image: null,
    errorMessage: '', // Add this line to handle error messages
});

const submit = () => {
    if (!form.image) {
        form.errorMessage = 'Please select an image before submitting.'; // Set the error message
        return;
    }
    form.errorMessage = ''; // Clear the error message if an image is selected
    const formData = new FormData();
    formData.append('image', imageInput.value.files[0]);  // Add image file to FormData

    form.post(route('tasks.submissions.store', props.task.id), {
        onSuccess: () => clearImageInput(),
        data: formData,  // Pass FormData with the image
        preserveScroll: true,
    });
};

const clearImageInput = () => {
    form.image = null;  // Clear the file in the form data
    form.errorMessage = ''; // Clear the error message
    if (imageInput.value) {
        imageInput.value.value = null; // Clear the file input element
    }
};
</script>

<template>
    <div class="container mx-auto p-4 bg-white rounded shadow-xl">
        <div
            v-if="userSubmissions.length === 0 || userSubmissions.every(submission => submission.status !== 'pending' && submission.status !== 'approved')">
            <div class="text-black text-xl my-4">Add a new submission</div>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <span class="relative inline-flex items-center">
                        <input
                            type="file"
                            ref="imageInput"
                            accept="image/*"
                            @input="form.image = $event.target.files[0]"
                            class="text-sm text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        />
                        <button
                            @click="clearImageInput"
                            v-if="form.image"
                            class="text-red-300 underline hover:text-red-100 ml-2">Clear
                        </button>
                    </span>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-xl">
                    Submit Image
                </button>

                <!-- Display error message if it exists -->
                <p v-if="form.errorMessage" class="text-red-500 mt-2">{{ form.errorMessage }}</p>

                <Transition>
                    <p v-if="form.recentlySuccessful" class="text-xl text-green-600">Saved.</p>
                </Transition>
            </form>
        </div>
        <div v-else-if="userSubmissions.some(submission => submission.status === 'pending')"
             class="text-gray-600 uppercase text-center font-bold text-xl">
            Your submission is waiting for review.
        </div>
        <div v-else class="text-green-600 uppercase text-center font-bold text-xl">
            Task solved
        </div>
    </div>
</template>
