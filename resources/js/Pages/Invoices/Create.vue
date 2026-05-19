<template>
    <ErpLayout title="Create Invoice">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Invoice</h1>
                <p class="text-muted mb-0">
                    Create a customer invoice.
                </p>
            </div>

            <Link href="/invoices" class="btn btn-outline-primary">
                Back to Invoices
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Invoice Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <InvoiceForm
                        :form="form"
                        :customers="customers"
                        :sales-orders="salesOrders"
                    />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/invoices" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import InvoiceForm from './Partials/InvoiceForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    customers: {
        type: Array,
        default: () => [],
    },
    salesOrders: {
        type: Array,
        default: () => [],
    },
});

const today = new Date().toISOString().slice(0, 10);

const form = useForm({
    customer_id: null,
    sales_order_id: null,
    invoice_number: `INV-${Date.now()}`,
    invoice_date: today,
    due_date: '',
    subtotal: 0,
    tax_amount: 0,
    discount_amount: 0,
    total_amount: 0,
    paid_amount: 0,
    status: 'unpaid',
    notes: '',
});

function submit() {
    form.post('/invoices');
}
</script>
