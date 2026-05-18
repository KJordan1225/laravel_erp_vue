<template>
    <ErpLayout title="Create Product">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Product</h1>
                <p class="text-muted mb-0">Add a new product to your ERP.</p>
            </div>

            <Link href="/products" class="btn btn-outline-primary">
                Back to Products
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Product Information
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
                            Save Product
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

defineProps({
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
    category_id: null,
    vendor_id: null,
    name: '',
    sku: '',
    description: '',
    purchase_price: 0,
    sale_price: 0,
    stock_quantity: 0,
    reorder_level: 5,
    is_active: true,
});

function submit() {
    form.post('/products');
}
</script>
