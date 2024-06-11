<script setup>
import {ref} from 'vue';
import {useForm} from "@inertiajs/vue3";

const imageInput = ref(null);
const props = defineProps({
    task: Object,
});

const form = useForm({
    image: null,
});

const submit = () => {
    const formData = new FormData();
    formData.append('image', imageInput.value.files[0]);  // Add image file to FormData

    form.post(route('tasks.submissions.store', props.task.id), {
        onSuccess: () => imageInput.value.value = '',
        data: formData,  // Pass FormData with the image
    });
};

</script>

<template>
    <form @submit.prevent="submit">
        <input type="file" ref="imageInput" accept="image/*" @input="form.image = $event.target.files[0]"/>
        <button type="submit">Submit Image</button>
    </form>
</template>
