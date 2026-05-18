<template>
    <ErpLayout title="Purchase Orders">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Purchase Orders</h1>
                <p class="text-muted mb-0">
                    Manage vendor purchase orders and receiving.
                </p>
            </div>

            <Link href="/purchase-orders/create" class="btn btn-erp-orange">
                Add Purchase Order
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Purchase Order List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>PO #</th>
                                <th>Vendor</th>
                                <th>Order Date</th>
                                <th>Expected Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="order in purchaseOrders.data"
                                :key="order.id"
                            >
                                <td>{{ order.purchase_order_number }}</td>
                                <td>{{ order.vendor?.name || '-' }}</td>
                                <td>{{ formatDate(order.order_date) }}</td>
                                <td>{{ formatDate(order.expected_date) }}</td>
                                <td>${{ money(order.total_amount) }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ order.status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/purchase-orders/${order.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/purchase-orders/${order.id}/edit`"
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

                            <tr v-if="purchaseOrders.data.length === 0">
                                <td colspan="7" class="text-center text-muted">
                                    No purchase orders found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ purchaseOrders.current_page }} of {{ purchaseOrders.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="purchaseOrders.prev_page_url"
                            :href="purchaseOrders.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="purchaseOrders.next_page_url"
                            :href="purchaseOrders.next_page_url"
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
    purchaseOrders: {
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
    if (window.confirm(`Delete purchase order "${order.purchase_order_number}"?`)) {
        router.delete(`/purchase-orders/${order.id}`);
    }
}
</script>
