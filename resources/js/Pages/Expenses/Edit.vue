<template>
    <ErpLayout title="Edit Expense">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Expense</h1>
                <p class="text-muted mb-0">
                    Update expense information.
                </p>
            </div>

            <Link href="/expenses" class="btn btn-outline-primary">
                Back to Expenses
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ expense.expense_number }}
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <ExpenseForm
                        :form="form"
                        :vendors="vendors"
                        :categories="categories"
                    />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/expenses" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Update Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import ExpenseForm from './Partials/ExpenseForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    expense: {
        type: Object,
        required: true,
    },
    vendors: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    vendor_id: props.expense.vendor_id || null,
    expense_number: props.expense.expense_number || '',
    category: props.expense.category || '',
    expense_date: props.expense.expense_date || '',
    amount: props.expense.amount || 0,
    payment_method: props.expense.payment_method || 'cash',
    reference_number: props.expense.reference_number || '',
    status: props.expense.status || 'paid',
    description: props.expense.description || '',
});

function submit() {
    form.put(`/expenses/${props.expense.id}`);
}
</script>
