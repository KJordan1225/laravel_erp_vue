<template>
    <ErpLayout title="Products">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Products</h1>
                <p class="text-muted mb-0">Manage products, pricing, and stock levels.</p>
            </div>

            <Link href="/products/create" class="btn btn-erp-orange">
                Add Product
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Product List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Vendor</th>
                                <th>Sale Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="product in products.data" :key="product.id">
                                <td>{{ product.name }}</td>
                                <td>{{ product.sku }}</td>
                                <td>{{ product.category?.name || '-' }}</td>
                                <td>{{ product.vendor?.name || '-' }}</td>
                                <td>${{ money(product.sale_price) }}</td>
                                <td>
                                    <span
                                        class="badge"
                                        :class="stockClass(product)"
                                    >
                                        {{ product.stock_quantity }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        v-if="product.is_active"
                                        class="badge bg-success"
                                    >
                                        Active
                                    </span>

                                    <span
                                        v-else
                                        class="badge bg-secondary"
                                    >
                                        Inactive
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/products/${product.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/products/${product.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteProduct(product)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="products.data.length === 0">
                                <td colspan="8" class="text-center text-muted">
                                    No products found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ products.current_page }} of {{ products.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="products.prev_page_url"
                            :href="products.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="products.next_page_url"
                            :href="products.next_page_url"
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
    products: {
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

function deleteProduct(product) {
    if (window.confirm(`Delete product "${product.name}"?`)) {
        router.delete(`/products/${product.id}`);
    }
}
</script>
