<template>
    <ErpLayout title="Invoice Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">
                    Invoice Details
                </h1>
                <p class="text-muted mb-0">
                    View invoice information and payments.
                </p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/invoices" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/invoices/${invoice.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card mb-4">
            <div class="erp-card-header">
                {{ invoice.invoice_number }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Customer:</strong>
                        <div>{{ invoice.customer?.name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span
                                class="badge"
                                :class="statusClass(invoice.status)"
                            >
                                {{ invoice.status }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Sales Order:</strong>
                        <div>{{ invoice.sales_order?.order_number || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Invoice Date:</strong>
                        <div>{{ formatDate(invoice.invoice_date) }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Due Date:</strong>
                        <div>{{ formatDate(invoice.due_date) }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Notes:</strong>
                        <div>{{ invoice.notes || '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="erp-card mb-4">
            <div class="erp-card-header">
                Invoice Totals
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th>Subtotal</th>
                                <td>${{ money(invoice.subtotal) }}</td>
                            </tr>

                            <tr>
                                <th>Tax Amount</th>
                                <td>${{ money(invoice.tax_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Discount Amount</th>
                                <td>${{ money(invoice.discount_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Total Amount</th>
                                <td>${{ money(invoice.total_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Paid Amount</th>
                                <td>${{ money(invoice.paid_amount) }}</td>
                            </tr>

                            <tr>
                                <th>Balance Due</th>
                                <td>${{ money(invoice.balance_due) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Payments
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Payment #</th>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="payment in invoice.payments"
                                :key="payment.id"
                            >
                                <td>{{ payment.payment_number }}</td>
                                <td>{{ formatDate(payment.payment_date) }}</td>
                                <td>{{ payment.payment_method }}</td>
                                <td>${{ money(payment.amount) }}</td>
                                <td>{{ payment.status }}</td>
                            </tr>

                            <tr v-if="invoice.payments.length === 0">
                                <td colspan="5" class="text-center text-muted">
                                    No payments found for this invoice.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    invoice: {
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
    if (status === 'paid') {
        return 'bg-success';
    }

    if (status === 'partial') {
        return 'bg-warning text-dark';
    }

    if (status === 'void') {
        return 'bg-secondary';
    }

    return 'bg-danger';
}
</script>
