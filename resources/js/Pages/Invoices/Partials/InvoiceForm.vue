<template>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Customer</label>

            <select
                v-model="form.customer_id"
                class="form-select"
                :class="{ 'is-invalid': form.errors.customer_id }"
            >
                <option :value="null">Select Customer</option>

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
            <label class="form-label">Sales Order Optional</label>

            <select
                v-model="form.sales_order_id"
                class="form-select"
                :class="{ 'is-invalid': form.errors.sales_order_id }"
                @change="fillFromSalesOrder"
            >
                <option :value="null">No Sales Order</option>

                <option
                    v-for="order in salesOrders"
                    :key="order.id"
                    :value="order.id"
                >
                    {{ order.order_number }} — {{ order.customer?.name || 'Customer' }}
                </option>
            </select>

            <div v-if="form.errors.sales_order_id" class="invalid-feedback">
                {{ form.errors.sales_order_id }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Invoice Number</label>

            <input
                v-model="form.invoice_number"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.invoice_number }"
            >

            <div v-if="form.errors.invoice_number" class="invalid-feedback">
                {{ form.errors.invoice_number }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Status</label>

            <select
                v-model="form.status"
                class="form-select"
                :class="{ 'is-invalid': form.errors.status }"
            >
                <option value="unpaid">Unpaid</option>
                <option value="partial">Partial</option>
                <option value="paid">Paid</option>
                <option value="void">Void</option>
            </select>

            <div v-if="form.errors.status" class="invalid-feedback">
                {{ form.errors.status }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Invoice Date</label>

            <input
                v-model="form.invoice_date"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': form.errors.invoice_date }"
            >

            <div v-if="form.errors.invoice_date" class="invalid-feedback">
                {{ form.errors.invoice_date }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Due Date</label>

            <input
                v-model="form.due_date"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': form.errors.due_date }"
            >

            <div v-if="form.errors.due_date" class="invalid-feedback">
                {{ form.errors.due_date }}
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Subtotal</label>

            <input
                v-model="form.subtotal"
                type="number"
                step="0.01"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.subtotal }"
            >

            <div v-if="form.errors.subtotal" class="invalid-feedback">
                {{ form.errors.subtotal }}
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Tax Amount</label>

            <input
                v-model="form.tax_amount"
                type="number"
                step="0.01"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.tax_amount }"
            >

            <div v-if="form.errors.tax_amount" class="invalid-feedback">
                {{ form.errors.tax_amount }}
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Discount Amount</label>

            <input
                v-model="form.discount_amount"
                type="number"
                step="0.01"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.discount_amount }"
            >

            <div v-if="form.errors.discount_amount" class="invalid-feedback">
                {{ form.errors.discount_amount }}
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Paid Amount</label>

            <input
                v-model="form.paid_amount"
                type="number"
                step="0.01"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.paid_amount }"
            >

            <div v-if="form.errors.paid_amount" class="invalid-feedback">
                {{ form.errors.paid_amount }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="erp-card">
                <div class="erp-card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="text-muted">Subtotal</div>
                            <strong>${{ money(form.subtotal) }}</strong>
                        </div>

                        <div class="col-md-3">
                            <div class="text-muted">Total</div>
                            <strong>${{ totalAmount }}</strong>
                        </div>

                        <div class="col-md-3">
                            <div class="text-muted">Paid</div>
                            <strong>${{ money(form.paid_amount) }}</strong>
                        </div>

                        <div class="col-md-3">
                            <div class="text-muted">Balance Due</div>
                            <strong>${{ balanceDue }}</strong>
                        </div>
                    </div>
                </div>
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
import { computed, watch } from 'vue';

const props = defineProps({
    form: {
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

const totalAmount = computed(() => {
    const total =
        Number(props.form.subtotal || 0)
        + Number(props.form.tax_amount || 0)
        - Number(props.form.discount_amount || 0);

    return money(total);
});

const balanceDue = computed(() => {
    const balance = Number(totalAmount.value) - Number(props.form.paid_amount || 0);

    return money(balance);
});

watch(
    () => [
        props.form.subtotal,
        props.form.tax_amount,
        props.form.discount_amount,
    ],
    () => {
        props.form.total_amount = totalAmount.value;
    },
    { immediate: true }
);

function fillFromSalesOrder() {
    const order = props.salesOrders.find((salesOrder) => {
        return Number(salesOrder.id) === Number(props.form.sales_order_id);
    });

    if (!order) {
        return;
    }

    props.form.customer_id = order.customer_id;
    props.form.subtotal = order.subtotal;
    props.form.tax_amount = order.tax_amount;
    props.form.discount_amount = order.discount_amount;
    props.form.total_amount = order.total_amount;
}

function money(value) {
    return Number(value || 0).toFixed(2);
}
</script>
