<template>
    <ErpLayout title="Create Expense">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Expense</h1>
                <p class="text-muted mb-0">
                    Record a business expense.
                </p>
            </div>

            <Link href="/expenses" class="btn btn-outline-primary">
                Back to Expenses
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Expense Information
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
                            Save Expense
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

defineProps({
    vendors: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const today = new Date().toISOString().slice(0, 10);

const form = useForm({
    vendor_id: null,
    expense_number: `EXP-${Date.now()}`,
    category: '',
    expense_date: today,
    amount: 0,
    payment_method: 'cash',
    reference_number: '',
    status: 'paid',
    description: '',
});

function submit() {
    form.post('/expenses');
}
</script>