<template>
    <ErpLayout title="Reports">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Reports</h1>
                <p class="text-muted mb-0">
                    Review ERP totals, activity, and low-stock products.
                </p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <StatCard title="Customers" :value="summary.customers" />
            </div>

            <div class="col-md-3">
                <StatCard title="Vendors" :value="summary.vendors" />
            </div>

            <div class="col-md-3">
                <StatCard title="Products" :value="summary.products" />
            </div>

            <div class="col-md-3">
                <StatCard title="Sales Orders" :value="summary.salesOrders" />
            </div>

            <div class="col-md-3">
                <StatCard title="Sales Total" :value="`$${money(summary.salesTotal)}`" />
            </div>

            <div class="col-md-3">
                <StatCard title="Purchase Total" :value="`$${money(summary.purchaseTotal)}`" />
            </div>

            <div class="col-md-3">
                <StatCard title="Invoice Total" :value="`$${money(summary.invoiceTotal)}`" />
            </div>

            <div class="col-md-3">
                <StatCard title="Balance Due" :value="`$${money(summary.invoiceBalanceDue)}`" />
            </div>

            <div class="col-md-3">
                <StatCard title="Payments" :value="`$${money(summary.paymentTotal)}`" />
            </div>

            <div class="col-md-3">
                <StatCard title="Expenses" :value="`$${money(summary.expenseTotal)}`" />
            </div>

            <div class="col-md-3">
                <StatCard title="Invoices" :value="summary.invoices" />
            </div>

            <div class="col-md-3">
                <StatCard title="Expense Records" :value="summary.expenses" />
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <ReportTable
                    title="Recent Sales Orders"
                    :headers="['Order #', 'Customer', 'Total', 'Status']"
                    :rows="salesOrderRows"
                />
            </div>

            <div class="col-lg-6">
                <ReportTable
                    title="Recent Purchase Orders"
                    :headers="['PO #', 'Vendor', 'Total', 'Status']"
                    :rows="purchaseOrderRows"
                />
            </div>

            <div class="col-lg-6">
                <ReportTable
                    title="Recent Invoices"
                    :headers="['Invoice #', 'Customer', 'Total', 'Balance']"
                    :rows="invoiceRows"
                />
            </div>

            <div class="col-lg-6">
                <ReportTable
                    title="Recent Payments"
                    :headers="['Payment #', 'Customer', 'Invoice', 'Amount']"
                    :rows="paymentRows"
                />
            </div>

            <div class="col-lg-6">
                <ReportTable
                    title="Recent Expenses"
                    :headers="['Expense #', 'Vendor', 'Category', 'Amount']"
                    :rows="expenseRows"
                />
            </div>

            <div class="col-lg-6">
                <ReportTable
                    title="Low Stock Products"
                    :headers="['Product', 'SKU', 'Stock', 'Reorder']"
                    :rows="lowStockRows"
                />
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import { computed } from 'vue';
import ErpLayout from '@/Layouts/ErpLayout.vue';
import StatCard from './Partials/StatCard.vue';
import ReportTable from './Partials/ReportTable.vue';

const props = defineProps({
    summary: {
        type: Object,
        required: true,
    },
    recentSalesOrders: {
        type: Array,
        default: () => [],
    },
    recentPurchaseOrders: {
        type: Array,
        default: () => [],
    },
    recentInvoices: {
        type: Array,
        default: () => [],
    },
    recentPayments: {
        type: Array,
        default: () => [],
    },
    recentExpenses: {
        type: Array,
        default: () => [],
    },
    lowStockProducts: {
        type: Array,
        default: () => [],
    },
});

const salesOrderRows = computed(() => {
    return props.recentSalesOrders.map((order) => [
        order.order_number,
        order.customer?.name || '-',
        `$${money(order.total_amount)}`,
        order.status,
    ]);
});

const purchaseOrderRows = computed(() => {
    return props.recentPurchaseOrders.map((order) => [
        order.purchase_order_number,
        order.vendor?.name || '-',
        `$${money(order.total_amount)}`,
        order.status,
    ]);
});

const invoiceRows = computed(() => {
    return props.recentInvoices.map((invoice) => [
        invoice.invoice_number,
        invoice.customer?.name || '-',
        `$${money(invoice.total_amount)}`,
        `$${money(invoice.balance_due)}`,
    ]);
});

const paymentRows = computed(() => {
    return props.recentPayments.map((payment) => [
        payment.payment_number,
        payment.customer?.name || '-',
        payment.invoice?.invoice_number || '-',
        `$${money(payment.amount)}`,
    ]);
});

const expenseRows = computed(() => {
    return props.recentExpenses.map((expense) => [
        expense.expense_number,
        expense.vendor?.name || '-',
        expense.category || '-',
        `$${money(expense.amount)}`,
    ]);
});

const lowStockRows = computed(() => {
    return props.lowStockProducts.map((product) => [
        product.name,
        product.sku,
        product.stock_quantity,
        product.reorder_level,
    ]);
});

function money(value) {
    return Number(value || 0).toFixed(2);
}
</script>
