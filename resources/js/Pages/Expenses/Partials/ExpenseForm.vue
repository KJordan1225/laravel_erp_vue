<template>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Vendor Optional</label>

            <select
                v-model="form.vendor_id"
                class="form-select"
                :class="{ 'is-invalid': form.errors.vendor_id }"
            >
                <option :value="null">No Vendor</option>

                <option
                    v-for="vendor in vendors"
                    :key="vendor.id"
                    :value="vendor.id"
                >
                    {{ vendor.name }}
                </option>
            </select>

            <div v-if="form.errors.vendor_id" class="invalid-feedback">
                {{ form.errors.vendor_id }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Expense Number</label>

            <input
                v-model="form.expense_number"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.expense_number }"
            >

            <div v-if="form.errors.expense_number" class="invalid-feedback">
                {{ form.errors.expense_number }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Category</label>

            <select
                v-model="form.category"
                class="form-select"
                :class="{ 'is-invalid': form.errors.category }"
            >
                <option value="">No Category</option>

                <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.name"
                >
                    {{ category.name }}
                </option>
            </select>

            <div v-if="form.errors.category" class="invalid-feedback">
                {{ form.errors.category }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Expense Date</label>

            <input
                v-model="form.expense_date"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': form.errors.expense_date }"
            >

            <div v-if="form.errors.expense_date" class="invalid-feedback">
                {{ form.errors.expense_date }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Amount</label>

            <input
                v-model="form.amount"
                type="number"
                step="0.01"
                min="0.01"
                class="form-control"
                :class="{ 'is-invalid': form.errors.amount }"
            >

            <div v-if="form.errors.amount" class="invalid-feedback">
                {{ form.errors.amount }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Payment Method</label>

            <select
                v-model="form.payment_method"
                class="form-select"
                :class="{ 'is-invalid': form.errors.payment_method }"
            >
                <option value="cash">Cash</option>
                <option value="check">Check</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="online">Online</option>
            </select>

            <div v-if="form.errors.payment_method" class="invalid-feedback">
                {{ form.errors.payment_method }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Reference Number</label>

            <input
                v-model="form.reference_number"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.reference_number }"
            >

            <div v-if="form.errors.reference_number" class="invalid-feedback">
                {{ form.errors.reference_number }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Status</label>

            <select
                v-model="form.status"
                class="form-select"
                :class="{ 'is-invalid': form.errors.status }"
            >
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
                <option value="pending">Pending</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <div v-if="form.errors.status" class="invalid-feedback">
                {{ form.errors.status }}
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">Description</label>

            <textarea
                v-model="form.description"
                class="form-control"
                rows="4"
                :class="{ 'is-invalid': form.errors.description }"
            ></textarea>

            <div v-if="form.errors.description" class="invalid-feedback">
                {{ form.errors.description }}
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    form: {
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
</script>
