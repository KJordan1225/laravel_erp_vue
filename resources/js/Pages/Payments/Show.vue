<template>
    <ErpLayout title="Payment Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">
                    Payment Details
                </h1>
                <p class="text-muted mb-0">
                    View payment information.
                </p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/payments" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/payments/${payment.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                {{ payment.payment_number }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Invoice:</strong>
                        <div>{{ payment.invoice?.invoice_number || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Customer:</strong>
                        <div>{{ payment.customer?.name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Payment Date:</strong>
                        <div>{{ formatDate(payment.payment_date) }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Payment Method:</strong>
                        <div>{{ payment.payment_method }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Amount:</strong>
                        <div>${{ money(payment.amount) }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span
                                class="badge"
                                :class="statusClass(payment.status)"
                            >
                                {{ payment.status }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Reference Number:</strong>
                        <div>{{ payment.reference_number || '-' }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Notes:</strong>
                        <div>{{ payment.notes || '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    payment: {
        type: Object,
        required: true,
    },
});

function money(value) {
    return Number(value || 0).toFixed(2);
}

function formatDate(value) {
    if (!value) {
        return '-';
    }

    return new Date(value).toLocaleDateString();
}

function statusClass(status) {
    if (status === 'completed') {
        return 'bg-success';
    }

    if (status === 'pending') {
        return 'bg-warning text-dark';
    }

    if (status === 'failed') {
        return 'bg-danger';
    }

    return 'bg-secondary';
}
</script>
