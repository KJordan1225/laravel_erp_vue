<template>
    <ErpLayout title="Sales Order Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">
                    Sales Order Details
                </h1>
                <p class="text-muted mb-0">
                    View sales order information.
                </p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/sales-orders" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/sales-orders/${salesOrder.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card mb-4">
            <div class="erp-card-header">
                {{ salesOrder.order_number }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Customer:</strong>
                        <div>{{ salesOrder.customer?.name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span class="badge bg-primary">
                                {{ salesOrder.status }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Order Date:</strong>
                        <div>{{ formatDate(salesOrder.order_date) }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Due Date:</strong>
                        <div>{{ formatDate(salesOrder.due_date) }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Notes:</strong>
                        <div>{{ salesOrder.notes || '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Line Items
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Line Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="item in salesOrder.items"
                                :key="item.id"
                            >
                                <td>{{ item.product?.name || '-' }}</td>
                                <td>{{ item.description }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>${{ money(item.unit_price) }}</td>
                                <td>${{ money(item.line_total) }}</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Subtotal</th>
                                <th>${{ money(salesOrder.subtotal) }}</th>
                            </tr>

                            <tr>
                                <th colspan="4" class="text-end">Tax</th>
                                <th>${{ money(salesOrder.tax_amount) }}</th>
                            </tr>

                            <tr>
                                <th colspan="4" class="text-end">Discount</th>
                                <th>${{ money(salesOrder.discount_amount) }}</th>
                            </tr>

                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th>${{ money(salesOrder.total_amount) }}</th>
                            </tr>
                        </tfoot>
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
    salesOrder: {
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
</script>
