<template>
    <ErpLayout title="Edit Product">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Product</h1>
                <p class="text-muted mb-0">Update product information.</p>
            </div>

            <Link href="/products" class="btn btn-outline-primary">
                Back to Products
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ product.name }}
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <ProductForm
                        :form="form"
                        :categories="categories"
                        :vendors="vendors"
                    />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/products" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import ProductForm from './Partials/ProductForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
    vendors: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    category_id: props.product.category_id || null,
    vendor_id: props.product.vendor_id || null,
    name: props.product.name || '',
    sku: props.product.sku || '',
    description: props.product.description || '',
    purchase_price: props.product.purchase_price || 0,
    sale_price: props.product.sale_price || 0,
    stock_quantity: props.product.stock_quantity || 0,
    reorder_level: props.product.reorder_level || 5,
    is_active: Boolean(props.product.is_active),
});

function submit() {
    form.put(`/products/${props.product.id}`);
}
</script>
