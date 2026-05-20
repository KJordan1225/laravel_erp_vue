<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Login" />

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">

                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">ERP Login</h4>
                        </div>

                        <div class="card-body">

                            <div
                                v-if="status"
                                class="alert alert-success"
                            >
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control"
                                        v-model="form.email"
                                        required
                                    >

                                    <div
                                        v-if="form.errors.email"
                                        class="text-danger small mt-1"
                                    >
                                        {{ form.errors.email }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control"
                                        v-model="form.password"
                                        required
                                    >

                                    <div
                                        v-if="form.errors.password"
                                        class="text-danger small mt-1"
                                    >
                                        {{ form.errors.password }}
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        v-model="form.remember"
                                    >

                                    <label class="form-check-label">
                                        Remember Me
                                    </label>
                                </div>

                                <button
                                    class="btn btn-primary w-100"
                                    :disabled="form.processing"
                                >
                                    Login
                                </button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </GuestLayout>
</template>
