<script setup>
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import imageCompression from 'browser-image-compression';

const imageInput = ref(null);
const props = defineProps({
    task: Object,
    userSubmissions: Object,
});

const form = useForm({
    image: null,
    errorMessage: '', // Add this line to handle error messages
});

const isCompressing = ref(false);

const compressImage = async (file) => {
    const options = {
        maxSizeMB: 2,
        maxWidthOrHeight: 1920,
        useWebWorker: true,
        fileType: 'image/webp',
        initialQuality: 0.7
    };

    try {
        console.log('Starting compression with options:', options);
        const compressedFile = await imageCompression(file, options);
        console.log('Compression completed successfully');
        return compressedFile;
    } catch (error) {
        console.error('Error compressing image:', error);
        // If compression fails, fall back to original file
        console.warn('Falling back to original file due to compression error');
        return file;
    }
};

const submit = async () => {
    if (!form.image) {
        form.errorMessage = 'Please select an image before submitting.';
        return;
    }
    
    form.errorMessage = '';
    isCompressing.value = true;
    
    try {
        const originalFile = imageInput.value.files[0];
        console.log('Original file:', originalFile.name, originalFile.size, 'bytes', originalFile.type);
        
        const compressedFile = await compressImage(originalFile);
        console.log('Compressed file:', compressedFile.name, compressedFile.size, 'bytes', compressedFile.type);
        
        // Update form with compressed file
        form.image = compressedFile;

        form.post(route('tasks.submissions.store', props.task.id), {
            onSuccess: () => clearImageInput(),
            forceFormData: true,
            preserveScroll: true,
            onFinish: () => {
                isCompressing.value = false;
            }
        });
    } catch (error) {
        console.error('Compression error:', error);
        form.errorMessage = 'Error processing image. Please try again.';
        isCompressing.value = false;
    }
};

const clearImageInput = () => {
    form.image = null;
    form.errorMessage = '';
    isCompressing.value = false;
    if (imageInput.value) {
        imageInput.value.value = null;
    }
};
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Task Already Completed -->
        <div v-if="userSubmissions.some(submission => submission.status === 'approved')" 
             class="p-6 text-center">
            <div class="flex flex-col items-center space-y-3">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-green-800">Užduotis išspręsta! / Task Completed! 🎉</h3>
                    <p class="text-green-600">Jūsų sprendimas patvirtintas ir gaus {{ task.points }} taškų / Your solution has been approved and you've earned {{ task.points }} points.</p>
                </div>
            </div>
        </div>

        <!-- Submission Under Review -->
        <div v-else-if="userSubmissions.some(submission => submission.status === 'pending')" 
             class="p-6 text-center">
            <div class="flex flex-col items-center space-y-3">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-yellow-800">Peržiūrima / Under Review</h3>
                    <p class="text-yellow-700">Jūsų sprendimas peržiūrimas. Pabandykite vėliau / Your submission is being reviewed. Check back later.</p>
                </div>
            </div>
        </div>

        <!-- Submit New Solution -->
        <div v-else class="p-6">
            <div class="text-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Pateikti sprendimą / Submit Your Solution</h3>
                <p class="text-gray-600">Įkelkite sprendimo nuotrauką ir gaukite {{ task.points }} taškų / Upload a photo of your solution to earn {{ task.points }} points</p>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- File Upload Button -->
                <div class="space-y-4">
                    <label for="image-upload" class="block">
                        <div class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-lg p-6 text-center cursor-pointer transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-white mb-1">Pasirinkite nuotrauką</h4>
                                    <h4 class="text-xl font-semibold text-white mb-3">Choose an Image</h4>
                                    <p class="text-blue-100 text-sm">PNG, JPG, WebP up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <input
                        id="image-upload"
                        type="file"
                        ref="imageInput"
                        accept="image/*"
                        @input="form.image = $event.target.files[0]"
                        class="hidden"
                    />
                </div>

                <!-- Selected File Info -->
                <div v-if="form.image" class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-medium text-gray-900">{{ form.image.name }}</p>
                                <p class="text-xs text-gray-500">{{ Math.round(form.image.size / 1024) }} KB</p>
                            </div>
                        </div>
                        <button
                            type="button"
                            @click="clearImageInput"
                            class="text-red-500 hover:text-red-700 font-medium text-sm"
                        >
                            Pašalinti / Remove
                        </button>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="form.errorMessage" class="p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ form.errorMessage }}</p>
                    </div>
                </div>

                <!-- Success Message -->
                <Transition
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <div v-if="form.recentlySuccessful" class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-700 font-medium">Sprendimas sėkmingai pateiktas! / Solution submitted successfully!</p>
                        </div>
                    </div>
                </Transition>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button 
                        type="submit" 
                        :disabled="!form.image || isCompressing || form.processing"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition-all duration-200 flex items-center space-x-2 min-w-[180px] justify-center"
                    >
                        <svg v-if="isCompressing || form.processing" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span v-if="isCompressing">Apdorojama nuotrauka... / Processing Image...</span>
                        <span v-else-if="form.processing">Pateikiama... / Submitting...</span>
                        <span v-else>Pateikti sprendimą / Submit Solution</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
