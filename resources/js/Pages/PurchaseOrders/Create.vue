<template>
    <ErpLayout title="Create Purchase Order">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Purchase Order</h1>
                <p class="text-muted mb-0">
                    Create a new purchase order for a vendor.
                </p>
            </div>

            <Link href="/purchase-orders" class="btn btn-outline-primary">
                Back to Purchase Orders
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Purchase Order Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <PurchaseOrderForm
                        :form="form"
                        :vendors="vendors"
                        :products="products"
                    />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/purchase-orders" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Purchase Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import PurchaseOrderForm from './Partials/PurchaseOrderForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    vendors: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
});

const today = new Date().toISOString().slice(0, 10);

const form = useForm({
    vendor_id: null,
    purchase_order_number: `PO-${Date.now()}`,
    order_date: today,
    expected_date: '',
    tax_amount: 0,
    discount_amount: 0,
    status: 'draft',
    notes: '',
    items: [
        {
            product_id: null,
            description: '',
            quantity: 1,
            unit_cost: 0,
        },
    ],
});

function submit() {
    form.post('/purchase-orders');
}
</script>
