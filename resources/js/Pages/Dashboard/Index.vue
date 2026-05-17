<template>
    <ErpLayout title="Dashboard">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Dashboard</h1>
                <p class="text-muted mb-0">
                    Welcome to your Laravel ERP system.
                </p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Customers</div>
                        <h2 class="mb-0">{{ stats.customers }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Vendors</div>
                        <h2 class="mb-0">{{ stats.vendors }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Products</div>
                        <h2 class="mb-0">{{ stats.products }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Sales Orders</div>
                        <h2 class="mb-0">{{ stats.salesOrders }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Purchase Orders</div>
                        <h2 class="mb-0">{{ stats.purchaseOrders }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Invoices</div>
                        <h2 class="mb-0">{{ stats.invoices }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Payments</div>
                        <h2 class="mb-0">${{ money(stats.paymentsTotal) }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="erp-card erp-stat-card">
                    <div class="erp-card-body">
                        <div class="text-muted">Expenses</div>
                        <h2 class="mb-0">${{ money(stats.expensesTotal) }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="erp-card">
                    <div class="erp-card-header">
                        Recent Invoices
                    </div>

                    <div class="erp-card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="invoice in recentInvoices" :key="invoice.id">
                                        <td>{{ invoice.invoice_number }}</td>
                                        <td>{{ invoice.customer?.name }}</td>
                                        <td>${{ money(invoice.total_amount) }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ invoice.status }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr v-if="recentInvoices.length === 0">
                                        <td colspan="4" class="text-center text-muted">
                                            No invoices yet.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="erp-card">
                    <div class="erp-card-header">
                        Recent Sales Orders
                    </div>

                    <div class="erp-card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="order in recentSalesOrders" :key="order.id">
                                        <td>{{ order.order_number }}</td>
                                        <td>{{ order.customer?.name }}</td>
                                        <td>${{ money(order.total_amount) }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                {{ order.status }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr v-if="recentSalesOrders.length === 0">
                                        <td colspan="4" class="text-center text-muted">
                                            No sales orders yet.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="erp-card">
                    <div class="erp-card-header">
                        Low Stock Products
                    </div>

                    <div class="erp-card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Stock</th>
                                        <th>Reorder Level</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="product in lowStockProducts" :key="product.id">
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.sku }}</td>
                                        <td>{{ product.stock_quantity }}</td>
                                        <td>{{ product.reorder_level }}</td>
                                    </tr>

                                    <tr v-if="lowStockProducts.length === 0">
                                        <td colspan="4" class="text-center text-muted">
                                            No low-stock products.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    recentInvoices: {
        type: Array,
        default: () => [],
    },
    recentSalesOrders: {
        type: Array,
        default: () => [],
    },
    lowStockProducts: {
        type: Array,
        default: () => [],
    },
});

function money(value) {
    return Number(value || 0).toFixed(2);
}
</script>
