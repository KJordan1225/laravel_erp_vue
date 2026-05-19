<template>
    <ErpLayout title="Expense Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">
                    Expense Details
                </h1>
                <p class="text-muted mb-0">
                    View expense information.
                </p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/expenses" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/expenses/${expense.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                {{ expense.expense_number }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Vendor:</strong>
                        <div>{{ expense.vendor?.name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Category:</strong>
                        <div>{{ expense.category || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Expense Date:</strong>
                        <div>{{ formatDate(expense.expense_date) }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Amount:</strong>
                        <div>${{ money(expense.amount) }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Payment Method:</strong>
                        <div>{{ expense.payment_method }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span
                                class="badge"
                                :class="statusClass(expense.status)"
                            >
                                {{ expense.status }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Reference Number:</strong>
                        <div>{{ expense.reference_number || '-' }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Description:</strong>
                        <div>{{ expense.description || '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    expense: {
        type: Object,
        required: true,
    },
});

function money(value) {
    return Number(value || 0).toFixed(2);
}

function formatDate(value) {
    if (!value) {
        return '-';
    }

    return new Date(value).toLocaleDateString();
}

function statusClass(status) {
    if (status === 'paid') {
        return 'bg-success';
    }

    if (status === 'pending') {
        return 'bg-warning text-dark';
    }

    if (status === 'cancelled') {
        return 'bg-secondary';
    }

    return 'bg-danger';
}
</script>
