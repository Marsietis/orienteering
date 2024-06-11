<script setup>
import {ref} from 'vue';
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const imageInput = ref(null);
const props = defineProps({
    task: Object,
});

const form = useForm({
    image: null,
});

const submit = () => {
    if (!form.image) return; // Don't submit if no image selected
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
    if (imageInput.value) {
        imageInput.value.value = null; // Clear the file input element
    }
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="relative">
            <input
                type="file"
                ref="imageInput"
                accept="image/*"
                @input="form.image = $event.target.files[0]"
                class="block w-full text-sm text-slate-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-full file:border-0
            file:text-sm file:font-semibold
            file:bg-violet-50 file:text-violet-700
            hover:file:bg-violet-100"
            />
        </div>
        <br>
        <button type="button" @click="clearImageInput" :disabled="!form.image">Clear</button>
        <br>
        <button type="submit">Submit Image</button>
        <InputError class="mt-2" :message="form.errors.image"/>

        <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
        >
            <p v-if="form.recentlySuccessful" class="text-xl text-green-600">Saved.</p>
        </Transition>
    </form>
</template>
