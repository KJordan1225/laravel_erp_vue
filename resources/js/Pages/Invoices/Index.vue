<template>
    <ErpLayout title="Invoices">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Invoices</h1>
                <p class="text-muted mb-0">
                    Manage customer invoices and balances.
                </p>
            </div>

            <Link href="/invoices/create" class="btn btn-erp-orange">
                Add Invoice
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Invoice List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Sales Order</th>
                                <th>Invoice Date</th>
                                <th>Total</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="invoice in invoices.data"
                                :key="invoice.id"
                            >
                                <td>{{ invoice.invoice_number }}</td>
                                <td>{{ invoice.customer?.name || '-' }}</td>
                                <td>{{ invoice.sales_order?.order_number || '-' }}</td>
                                <td>{{ formatDate(invoice.invoice_date) }}</td>
                                <td>${{ money(invoice.total_amount) }}</td>
                                <td>${{ money(invoice.balance_due) }}</td>
                                <td>
                                    <span
                                        class="badge"
                                        :class="statusClass(invoice.status)"
                                    >
                                        {{ invoice.status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/invoices/${invoice.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/invoices/${invoice.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteInvoice(invoice)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="invoices.data.length === 0">
                                <td colspan="8" class="text-center text-muted">
                                    No invoices found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ invoices.current_page }} of {{ invoices.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="invoices.prev_page_url"
                            :href="invoices.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="invoices.next_page_url"
                            :href="invoices.next_page_url"
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
    invoices: {
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

function deleteInvoice(invoice) {
    if (window.confirm(`Delete invoice "${invoice.invoice_number}"?`)) {
        router.delete(`/invoices/${invoice.id}`);
    }
}
</script>
