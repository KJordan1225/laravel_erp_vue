<template>
    <ErpLayout title="Expenses">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Expenses</h1>
                <p class="text-muted mb-0">
                    Track business expenses and payments.
                </p>
            </div>

            <Link href="/expenses/create" class="btn btn-erp-orange">
                Add Expense
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Expense List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Expense #</th>
                                <th>Vendor</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="expense in expenses.data"
                                :key="expense.id"
                            >
                                <td>{{ expense.expense_number }}</td>
                                <td>{{ expense.vendor?.name || '-' }}</td>
                                <td>{{ expense.category || '-' }}</td>
                                <td>{{ formatDate(expense.expense_date) }}</td>
                                <td>${{ money(expense.amount) }}</td>
                                <td>{{ expense.payment_method }}</td>
                                <td>
                                    <span
                                        class="badge"
                                        :class="statusClass(expense.status)"
                                    >
                                        {{ expense.status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/expenses/${expense.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/expenses/${expense.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteExpense(expense)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="expenses.data.length === 0">
                                <td colspan="8" class="text-center text-muted">
                                    No expenses found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ expenses.current_page }} of {{ expenses.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="expenses.prev_page_url"
                            :href="expenses.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="expenses.next_page_url"
                            :href="expenses.next_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Next
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    expenses: {
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

function deleteExpense(expense) {
    if (window.confirm(`Delete expense "${expense.expense_number}"?`)) {
        router.delete(`/expenses/${expense.id}`);
    }
}
</script>
