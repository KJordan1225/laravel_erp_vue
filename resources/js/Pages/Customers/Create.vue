<template>
    <ErpLayout title="Create Customer">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Customer</h1>
                <p class="text-muted mb-0">Add a new customer.</p>
            </div>

            <Link href="/customers" class="btn btn-outline-primary">
                Back to Customers
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Customer Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <CustomerForm :form="form" />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/customers" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import CustomerForm from './Partials/CustomerForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    company_name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    postal_code: '',
    country: 'USA',
    notes: '',
    is_active: true,
});

function submit() {
    form.post('/customers');
}
</script>
