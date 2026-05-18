<template>
    <ErpLayout title="Inventory">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Inventory</h1>
                <p class="text-muted mb-0">
                    Track stock in, stock out, and inventory adjustments.
                </p>
            </div>

            <Link href="/inventory/create" class="btn btn-erp-orange">
                Add Movement
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Inventory Movements
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Reference</th>
                                <th>Date</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="item in inventoryItems.data"
                                :key="item.id"
                            >
                                <td>{{ item.product?.name || '-' }}</td>
                                <td>{{ item.product?.sku || '-' }}</td>
                                <td>
                                    <span
                                        class="badge"
                                        :class="movementClass(item.movement_type)"
                                    >
                                        {{ movementLabel(item.movement_type) }}
                                    </span>
                                </td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.reference || '-' }}</td>
                                <td>{{ formatDate(item.created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/inventory/${item.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/inventory/${item.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteMovement(item)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="inventoryItems.data.length === 0">
                                <td colspan="7" class="text-center text-muted">
                                    No inventory movements found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ inventoryItems.current_page }} of {{ inventoryItems.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="inventoryItems.prev_page_url"
                            :href="inventoryItems.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="inventoryItems.next_page_url"
                            :href="inventoryItems.next_page_url"
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
    inventoryItems: {
        type: Object,
        required: true,
    },
});

function movementLabel(type) {
    if (type === 'in') {
        return 'Stock In';
    }

    if (type === 'out') {
        return 'Stock Out';
    }

    return 'Adjustment';
}

function movementClass(type) {
    if (type === 'in') {
        return 'bg-success';
    }

    if (type === 'out') {
        return 'bg-danger';
    }

    return 'bg-warning text-dark';
}

function formatDate(value) {
    if (!value) {
        return '-';
    }

    return new Date(value).toLocaleDateString();
}

function deleteMovement(item) {
    if (window.confirm('Delete this inventory movement?')) {
        router.delete(`/inventory/${item.id}`);
    }
}
</script>
