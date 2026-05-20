<template>
    <ErpLayout title="Payments">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Payments</h1>
                <p class="text-muted mb-0">
                    Manage customer payments and invoice balances.
                </p>
            </div>

            <Link href="/payments/create" class="btn btn-erp-orange">
                Add Payment
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Payment List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Payment #</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="payment in payments.data"
                                :key="payment.id"
                            >
                                <td>{{ payment.payment_number }}</td>
                                <td>{{ payment.invoice?.invoice_number || '-' }}</td>
                                <td>{{ payment.customer?.name || '-' }}</td>
                                <td>{{ formatDate(payment.payment_date) }}</td>
                                <td>{{ payment.payment_method }}</td>
                                <td>${{ money(payment.amount) }}</td>
                                <td>
                                    <span
                                        class="badge"
                                        :class="statusClass(payment.status)"
                                    >
                                        {{ payment.status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/payments/${payment.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/payments/${payment.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deletePayment(payment)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="payments.data.length === 0">
                                <td colspan="8" class="text-center text-muted">
                                    No payments found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ payments.current_page }} of {{ payments.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="payments.prev_page_url"
                            :href="payments.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="payments.next_page_url"
                            :href="payments.next_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Next
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    payments: {
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

function deletePayment(payment) {
    if (window.confirm(`Delete payment "${payment.payment_number}"?`)) {
        router.delete(`/payments/${payment.id}`);
    }
}
</script>
