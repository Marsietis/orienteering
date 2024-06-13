<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    members: [],
});

const step = ref(1);
const newMemberName = ref('');

const nextStep = () => {
    if (step.value === 1) {
        step.value++;
    } else {
        submit();
    }
};

const previousStep = () => {
    if (step.value > 1) {
        step.value--;
    }
};

const addMember = () => {
    if (newMemberName.value.trim() !== '' && form.members.length < 6) {
        form.members.push(newMemberName.value);
        newMemberName.value = '';
    } else if (form.members.length >= 6) {
        form.setError('members', 'The team can have a maximum of 6 members.');
    } else if (newMemberName.value.trim() === '') {
        form.setError('members', 'Enter the team member\'s name.');
    }
};

const removeMember = (index) => {
    form.members.splice(index, 1);
};

const submit = () => {
    if (form.members.length < 3 || form.members.length > 6) {
        form.setError('members', 'The team must have between 3 and 6 members.');
        return;
    }

    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
        onError: (errors) => {
            if (errors.name || errors.email || errors.password || errors.password_confirmation) {
                step.value = 1;
            } else if (errors.members) {
                step.value = 2;
            }
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>

        <form @submit.prevent="nextStep">
            <div v-if="step === 1">
                <div>
                    <InputLabel for="name" value="Team name"/>

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Student email (f.e. slagbaumas.algis@knf.stud.vu.lt)"/>

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password"/>

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password"/>

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password_confirmation"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link
                        :href="route('login')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Next
                    </PrimaryButton>
                </div>
            </div>

            <div v-if="step === 2">
                <InputLabel for="newMemberName" value="Team member's name"/>
                <div class="flex items-center">

                    <TextInput
                        id="newMemberName"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="newMemberName"
                    />

                    <SecondaryButton type="button" class="mt-1 ml-2" @click="addMember">
                        + Add Member
                    </SecondaryButton>
                </div>

                <InputError class="mt-2" :message="form.errors.members"/>

                <div class="mt-4">
                    <h3>Team Members</h3>
                    <ul>
                        <li v-for="(member, index) in form.members" :key="index">
                            {{ member }}
                            <a @click="removeMember(index)"
                               class="text-red-500 hover:text-red-600 hover:underline ml-2">
                                Remove
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <SecondaryButton type="button" class="me-4" @click="previousStep">
                        Previous
                    </SecondaryButton>

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
