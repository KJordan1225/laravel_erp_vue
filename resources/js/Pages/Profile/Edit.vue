<template>
    <ErpLayout title="User Profile">
        <div class="mb-4">
            <h1 class="erp-page-title mb-1">User Profile</h1>
            <p class="text-muted mb-0">
                Manage your account information.
            </p>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Profile Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.name }"
                            >
                            <div v-if="form.errors.name" class="invalid-feedback">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.email }"
                            >
                            <div v-if="form.errors.email" class="invalid-feedback">
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">New Password Optional</label>
                            <input
                                v-model="form.password"
                                type="password"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.password }"
                            >
                            <div v-if="form.errors.password" class="invalid-feedback">
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password</label>
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                class="form-control"
                            >
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.user.name || '',
    email: props.user.email || '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.put('/profile', {
        onSuccess: () => {
            form.password = '';
            form.password_confirmation = '';
        },
    });
}
</script>
