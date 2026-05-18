<template>
    <ErpLayout title="Edit Purchase Order">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Purchase Order</h1>
                <p class="text-muted mb-0">
                    Update purchase order information.
                </p>
            </div>

            <Link href="/purchase-orders" class="btn btn-outline-primary">
                Back to Purchase Orders
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ purchaseOrder.purchase_order_number }}
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
                            Update Purchase Order
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

const props = defineProps({
    purchaseOrder: {
        type: Object,
        required: true,
    },
    vendors: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    vendor_id: props.purchaseOrder.vendor_id || null,
    purchase_order_number: props.purchaseOrder.purchase_order_number || '',
    order_date: props.purchaseOrder.order_date || '',
    expected_date: props.purchaseOrder.expected_date || '',
    tax_amount: props.purchaseOrder.tax_amount || 0,
    discount_amount: props.purchaseOrder.discount_amount || 0,
    status: props.purchaseOrder.status || 'draft',
    notes: props.purchaseOrder.notes || '',
    items: props.purchaseOrder.items.length
        ? props.purchaseOrder.items.map((item) => ({
            product_id: item.product_id,
            description: item.description,
            quantity: item.quantity,
            unit_cost: item.unit_cost,
        }))
        : [
            {
                product_id: null,
                description: '',
                quantity: 1,
                unit_cost: 0,
            },
        ],
});

function submit() {
    form.put(`/purchase-orders/${props.purchaseOrder.id}`);
}
</script>
