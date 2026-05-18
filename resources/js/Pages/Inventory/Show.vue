<template>
    <ErpLayout title="Inventory Movement Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">
                    Inventory Movement Details
                </h1>
                <p class="text-muted mb-0">
                    View inventory movement information.
                </p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/inventory" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/inventory/${inventoryItem.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                {{ inventoryItem.product?.name || 'Inventory Movement' }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Product:</strong>
                        <div>{{ inventoryItem.product?.name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>SKU:</strong>
                        <div>{{ inventoryItem.product?.sku || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Movement Type:</strong>
                        <div>
                            <span
                                class="badge"
                                :class="movementClass(inventoryItem.movement_type)"
                            >
                                {{ movementLabel(inventoryItem.movement_type) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Quantity:</strong>
                        <div>{{ inventoryItem.quantity }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Reference:</strong>
                        <div>{{ inventoryItem.reference || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Date:</strong>
                        <div>{{ formatDate(inventoryItem.created_at) }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Notes:</strong>
                        <div>{{ inventoryItem.notes || '-' }}</div>
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
    inventoryItem: {
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
</script>
