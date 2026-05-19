<template>
    <ErpLayout title="Edit Payment">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Payment</h1>
                <p class="text-muted mb-0">
                    Update payment information.
                </p>
            </div>

            <Link href="/payments" class="btn btn-outline-primary">
                Back to Payments
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ payment.payment_number }}
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
                            Update Payment
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

const props = defineProps({
    payment: {
        type: Object,
        required: true,
    },
    customers: {
        type: Array,
        default: () => [],
    },
    invoices: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    invoice_id: props.payment.invoice_id || null,
    customer_id: props.payment.customer_id || null,
    payment_number: props.payment.payment_number || '',
    payment_date: props.payment.payment_date || '',
    amount: props.payment.amount || 0,
    payment_method: props.payment.payment_method || 'cash',
    reference_number: props.payment.reference_number || '',
    status: props.payment.status || 'completed',
    notes: props.payment.notes || '',
});

function submit() {
    form.put(`/payments/${props.payment.id}`);
}
</script>
