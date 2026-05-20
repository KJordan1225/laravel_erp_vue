<template>
    <ErpLayout title="Company Settings">
        <div class="mb-4">
            <h1 class="erp-page-title mb-1">Company Settings</h1>
            <p class="text-muted mb-0">
                Manage your business identity and default ERP settings.
            </p>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Business Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Company Name</label>
                            <input
                                v-model="form.company_name"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.company_name }"
                            >
                            <div v-if="form.errors.company_name" class="invalid-feedback">
                                {{ form.errors.company_name }}
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
                            <label class="form-label">Phone</label>
                            <input
                                v-model="form.phone"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.phone }"
                            >
                            <div v-if="form.errors.phone" class="invalid-feedback">
                                {{ form.errors.phone }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Website</label>
                            <input
                                v-model="form.website"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.website }"
                            >
                            <div v-if="form.errors.website" class="invalid-feedback">
                                {{ form.errors.website }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input
                                v-model="form.address"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.address }"
                            >
                            <div v-if="form.errors.address" class="invalid-feedback">
                                {{ form.errors.address }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input
                                v-model="form.city"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.city }"
                            >
                            <div v-if="form.errors.city" class="invalid-feedback">
                                {{ form.errors.city }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input
                                v-model="form.state"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.state }"
                            >
                            <div v-if="form.errors.state" class="invalid-feedback">
                                {{ form.errors.state }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Postal Code</label>
                            <input
                                v-model="form.postal_code"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.postal_code }"
                            >
                            <div v-if="form.errors.postal_code" class="invalid-feedback">
                                {{ form.errors.postal_code }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <input
                                v-model="form.country"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.country }"
                            >
                            <div v-if="form.errors.country" class="invalid-feedback">
                                {{ form.errors.country }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Currency</label>
                            <input
                                v-model="form.currency"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.currency }"
                            >
                            <div v-if="form.errors.currency" class="invalid-feedback">
                                {{ form.errors.currency }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Default Tax Rate</label>
                            <input
                                v-model="form.tax_rate"
                                type="number"
                                step="0.01"
                                min="0"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.tax_rate }"
                            >
                            <div v-if="form.errors.tax_rate" class="invalid-feedback">
                                {{ form.errors.tax_rate }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Settings
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
    settings: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    company_name: props.settings.company_name || '',
    email: props.settings.email || '',
    phone: props.settings.phone || '',
    website: props.settings.website || '',
    address: props.settings.address || '',
    city: props.settings.city || '',
    state: props.settings.state || '',
    postal_code: props.settings.postal_code || '',
    country: props.settings.country || 'USA',
    currency: props.settings.currency || 'USD',
    tax_rate: props.settings.tax_rate || 0,
});

function submit() {
    form.put('/company-settings');
}
</script>
