<template>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Invoice Optional</label>

            <select
                v-model="form.invoice_id"
                class="form-select"
                :class="{ 'is-invalid': form.errors.invoice_id }"
                @change="fillFromInvoice"
            >
                <option :value="null">No Invoice</option>

                <option
                    v-for="invoice in invoices"
                    :key="invoice.id"
                    :value="invoice.id"
                >
                    {{ invoice.invoice_number }} —
                    {{ invoice.customer?.name || 'Customer' }}
                    —
                    Balance: ${{ money(invoice.balance_due) }}
                </option>
            </select>

            <div v-if="form.errors.invoice_id" class="invalid-feedback">
                {{ form.errors.invoice_id }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Customer Optional</label>

            <select
                v-model="form.customer_id"
                class="form-select"
                :class="{ 'is-invalid': form.errors.customer_id }"
            >
                <option :value="null">No Customer</option>

                <option
                    v-for="customer in customers"
                    :key="customer.id"
                    :value="customer.id"
                >
                    {{ customer.name }}
                </option>
            </select>

            <div v-if="form.errors.customer_id" class="invalid-feedback">
                {{ form.errors.customer_id }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Payment Number</label>

            <input
                v-model="form.payment_number"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.payment_number }"
            >

            <div v-if="form.errors.payment_number" class="invalid-feedback">
                {{ form.errors.payment_number }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Payment Date</label>

            <input
                v-model="form.payment_date"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': form.errors.payment_date }"
            >

            <div v-if="form.errors.payment_date" class="invalid-feedback">
                {{ form.errors.payment_date }}
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
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="failed">Failed</option>
                <option value="refunded">Refunded</option>
            </select>

            <div v-if="form.errors.status" class="invalid-feedback">
                {{ form.errors.status }}
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">Notes</label>

            <textarea
                v-model="form.notes"
                class="form-control"
                rows="4"
                :class="{ 'is-invalid': form.errors.notes }"
            ></textarea>

            <div v-if="form.errors.notes" class="invalid-feedback">
                {{ form.errors.notes }}
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    customers: {
        type: Array,
        default: () => [],
    },
    invoices: {
        type: Array,
        default: () => [],
    },
});

function fillFromInvoice() {
    const invoice = props.invoices.find((invoice) => {
        return Number(invoice.id) === Number(props.form.invoice_id);
    });

    if (!invoice) {
        return;
    }

    props.form.customer_id = invoice.customer_id;
    props.form.amount = invoice.balance_due || invoice.total_amount || 0;
}

function money(value) {
    return Number(value || 0).toFixed(2);
}
</script>
