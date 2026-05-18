<template>
    <ErpLayout title="Sales Orders">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Sales Orders</h1>
                <p class="text-muted mb-0">
                    Manage customer sales orders and order totals.
                </p>
            </div>

            <Link href="/sales-orders/create" class="btn btn-erp-orange">
                Add Sales Order
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Sales Order List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="order in salesOrders.data"
                                :key="order.id"
                            >
                                <td>{{ order.order_number }}</td>
                                <td>{{ order.customer?.name || '-' }}</td>
                                <td>{{ formatDate(order.order_date) }}</td>
                                <td>${{ money(order.total_amount) }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ order.status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/sales-orders/${order.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/sales-orders/${order.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteOrder(order)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="salesOrders.data.length === 0">
                                <td colspan="6" class="text-center text-muted">
                                    No sales orders found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ salesOrders.current_page }} of {{ salesOrders.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="salesOrders.prev_page_url"
                            :href="salesOrders.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="salesOrders.next_page_url"
                            :href="salesOrders.next_page_url"
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
    salesOrders: {
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

function deleteOrder(order) {
    if (window.confirm(`Delete sales order "${order.order_number}"?`)) {
        router.delete(`/sales-orders/${order.id}`);
    }
}
</script>
