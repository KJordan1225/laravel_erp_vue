<template>
    <ErpLayout title="Edit Sales Order">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Sales Order</h1>
                <p class="text-muted mb-0">
                    Update sales order information.
                </p>
            </div>

            <Link href="/sales-orders" class="btn btn-outline-primary">
                Back to Sales Orders
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ salesOrder.order_number }}
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <SalesOrderForm
                        :form="form"
                        :customers="customers"
                        :products="products"
                    />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/sales-orders" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Update Sales Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import SalesOrderForm from './Partials/SalesOrderForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    salesOrder: {
        type: Object,
        required: true,
    },
    customers: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    customer_id: props.salesOrder.customer_id || null,
    order_number: props.salesOrder.order_number || '',
    order_date: props.salesOrder.order_date || '',
    due_date: props.salesOrder.due_date || '',
    tax_amount: props.salesOrder.tax_amount || 0,
    discount_amount: props.salesOrder.discount_amount || 0,
    status: props.salesOrder.status || 'draft',
    notes: props.salesOrder.notes || '',
    items: props.salesOrder.items.length
        ? props.salesOrder.items.map((item) => ({
            product_id: item.product_id,
            description: item.description,
            quantity: item.quantity,
            unit_price: item.unit_price,
        }))
        : [
            {
                product_id: null,
                description: '',
                quantity: 1,
                unit_price: 0,
            },
        ],
});

function submit() {
    form.put(`/sales-orders/${props.salesOrder.id}`);
}
</script>
