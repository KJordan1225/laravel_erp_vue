<template>
    <ErpLayout title="Create Payment">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Payment</h1>
                <p class="text-muted mb-0">
                    Record a customer payment.
                </p>
            </div>

            <Link href="/payments" class="btn btn-outline-primary">
                Back to Payments
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Payment Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <PaymentForm
                        :form="form"
                        :customers="customers"
                        :invoices="invoices"
                    />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/payments" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import PaymentForm from './Partials/PaymentForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    customers: {
        type: Array,
        default: () => [],
    },
    invoices: {
        type: Array,
        default: () => [],
    },
});

const today = new Date().toISOString().slice(0, 10);

const form = useForm({
    invoice_id: null,
    customer_id: null,
    payment_number: `PAY-${Date.now()}`,
    payment_date: today,
    amount: 0,
    payment_method: 'cash',
    reference_number: '',
    status: 'completed',
    notes: '',
});

function submit() {
    form.post('/payments');
}
</script>
