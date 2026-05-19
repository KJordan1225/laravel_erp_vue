<template>
    <ErpLayout title="Edit Invoice">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Invoice</h1>
                <p class="text-muted mb-0">
                    Update invoice information.
                </p>
            </div>

            <Link href="/invoices" class="btn btn-outline-primary">
                Back to Invoices
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ invoice.invoice_number }}
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
                            Update Invoice
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

const props = defineProps({
    invoice: {
        type: Object,
        required: true,
    },
    customers: {
        type: Array,
        default: () => [],
    },
    salesOrders: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    customer_id: props.invoice.customer_id || null,
    sales_order_id: props.invoice.sales_order_id || null,
    invoice_number: props.invoice.invoice_number || '',
    invoice_date: props.invoice.invoice_date || '',
    due_date: props.invoice.due_date || '',
    subtotal: props.invoice.subtotal || 0,
    tax_amount: props.invoice.tax_amount || 0,
    discount_amount: props.invoice.discount_amount || 0,
    total_amount: props.invoice.total_amount || 0,
    paid_amount: props.invoice.paid_amount || 0,
    status: props.invoice.status || 'unpaid',
    notes: props.invoice.notes || '',
});

function submit() {
    form.put(`/invoices/${props.invoice.id}`);
}
</script>
