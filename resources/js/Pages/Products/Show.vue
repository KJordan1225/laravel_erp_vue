<template>
    <ErpLayout title="Product Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Product Details</h1>
                <p class="text-muted mb-0">View product information.</p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/products" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/products/${product.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                {{ product.name }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ product.name }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>SKU:</strong>
                        <div>{{ product.sku }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Category:</strong>
                        <div>{{ product.category?.name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Vendor:</strong>
                        <div>{{ product.vendor?.name || '-' }}</div>
                    </div>

                    <div class="col-md-3">
                        <strong>Purchase Price:</strong>
                        <div>${{ money(product.purchase_price) }}</div>
                    </div>

                    <div class="col-md-3">
                        <strong>Sale Price:</strong>
                        <div>${{ money(product.sale_price) }}</div>
                    </div>

                    <div class="col-md-3">
                        <strong>Stock Quantity:</strong>
                        <div>
                            <span
                                class="badge"
                                :class="stockClass(product)"
                            >
                                {{ product.stock_quantity }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <strong>Reorder Level:</strong>
                        <div>{{ product.reorder_level }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span v-if="product.is_active" class="badge bg-success">
                                Active
                            </span>

                            <span v-else class="badge bg-secondary">
                                Inactive
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <strong>Description:</strong>
                        <div>{{ product.description || '-' }}</div>
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
    product: {
        type: Object,
        required: true,
    },
});

function money(value) {
    return Number(value || 0).toFixed(2);
}

function stockClass(product) {
    if (Number(product.stock_quantity) <= Number(product.reorder_level)) {
        return 'bg-danger';
    }

    return 'bg-success';
}
</script>
