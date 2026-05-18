<template>
    <ErpLayout title="Create Sales Order">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Sales Order</h1>
                <p class="text-muted mb-0">
                    Create a new order for a customer.
                </p>
            </div>

            <Link href="/sales-orders" class="btn btn-outline-primary">
                Back to Sales Orders
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Sales Order Information
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
                            Save Sales Order
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

defineProps({
    customers: {
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
    customer_id: null,
    order_number: `SO-${Date.now()}`,
    order_date: today,
    due_date: '',
    tax_amount: 0,
    discount_amount: 0,
    status: 'draft',
    notes: '',
    items: [
        {
            product_id: null,
            description: '',
            quantity: 1,
            unit_price: 0,
        },
    ],
});

function submit() {
    form.post('/sales-orders');
}
</script>
