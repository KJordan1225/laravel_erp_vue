<template>
    <ErpLayout title="Create Vendor">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Vendor</h1>
                <p class="text-muted mb-0">Add a new vendor.</p>
            </div>

            <Link href="/vendors" class="btn btn-outline-primary">
                Back to Vendors
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Vendor Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <VendorForm :form="form" />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/vendors" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Vendor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import VendorForm from './Partials/VendorForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    company_name: '',
    email: '',
    phone: '',
    website: '',
    address: '',
    city: '',
    state: '',
    postal_code: '',
    country: 'USA',
    notes: '',
    is_active: true,
});

function submit() {
    form.post('/vendors');
}
</script>
