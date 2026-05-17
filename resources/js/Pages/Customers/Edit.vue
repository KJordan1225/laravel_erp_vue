<template>
    <ErpLayout title="Edit Customer">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Customer</h1>
                <p class="text-muted mb-0">Update customer information.</p>
            </div>

            <Link href="/customers" class="btn btn-outline-primary">
                Back to Customers
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ customer.name }}
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
                            Update Customer
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

const props = defineProps({
    customer: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.customer.name || '',
    company_name: props.customer.company_name || '',
    email: props.customer.email || '',
    phone: props.customer.phone || '',
    address: props.customer.address || '',
    city: props.customer.city || '',
    state: props.customer.state || '',
    postal_code: props.customer.postal_code || '',
    country: props.customer.country || 'USA',
    notes: props.customer.notes || '',
    is_active: Boolean(props.customer.is_active),
});

function submit() {
    form.put(`/customers/${props.customer.id}`);
}
</script>
