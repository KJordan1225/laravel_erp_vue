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
            <label class="form-label">Order Number</label>

            <input
                v-model="form.order_number"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.order_number }"
            >

            <div v-if="form.errors.order_number" class="invalid-feedback">
                {{ form.errors.order_number }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Order Date</label>

            <input
                v-model="form.order_date"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': form.errors.order_date }"
            >

            <div v-if="form.errors.order_date" class="invalid-feedback">
                {{ form.errors.order_date }}
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

        <div class="col-md-6">
            <label class="form-label">Status</label>

            <select
                v-model="form.status"
                class="form-select"
                :class="{ 'is-invalid': form.errors.status }"
            >
                <option value="draft">Draft</option>
                <option value="confirmed">Confirmed</option>
                <option value="fulfilled">Fulfilled</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <div v-if="form.errors.status" class="invalid-feedback">
                {{ form.errors.status }}
            </div>
        </div>

        <div class="col-md-12">
            <hr>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Line Items</h5>

                <button
                    type="button"
                    class="btn btn-sm btn-erp-orange"
                    @click="addItem"
                >
                    Add Item
                </button>
            </div>

            <div
                v-for="(item, index) in form.items"
                :key="index"
                class="border rounded p-3 mb-3"
            >
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Product</label>

                        <select
                            v-model="item.product_id"
                            class="form-select"
                            @change="fillProduct(index)"
                        >
                            <option :value="null">No Product</option>

                            <option
                                v-for="product in products"
                                :key="product.id"
                                :value="product.id"
                            >
                                {{ product.name }} — {{ product.sku }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Description</label>

                        <input
                            v-model="item.description"
                            type="text"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Quantity</label>

                        <input
                            v-model="item.quantity"
                            type="number"
                            min="1"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Unit Price</label>

                        <input
                            v-model="item.unit_price"
                            type="number"
                            step="0.01"
                            min="0"
                            class="form-control"
                        >
                    </div>

                    <div class="col-md-12 d-flex justify-content-between">
                        <div>
                            <strong>Line Total:</strong>
                            ${{ lineTotal(item) }}
                        </div>

                        <button
                            type="button"
                            class="btn btn-sm btn-danger"
                            @click="removeItem(index)"
                            :disabled="form.items.length === 1"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="form.errors.items" class="text-danger">
                {{ form.errors.items }}
            </div>
        </div>

        <div class="col-md-4">
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

        <div class="col-md-4">
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

        <div class="col-md-4">
            <div class="erp-card h-100">
                <div class="erp-card-body">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <strong>${{ subtotal }}</strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Tax:</span>
                        <strong>${{ money(form.tax_amount) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Discount:</span>
                        <strong>${{ money(form.discount_amount) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Total:</span>
                        <strong>${{ total }}</strong>
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
import { computed } from 'vue';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    customers: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
});

function addItem() {
    props.form.items.push({
        product_id: null,
        description: '',
        quantity: 1,
        unit_price: 0,
    });
}

function removeItem(index) {
    if (props.form.items.length > 1) {
        props.form.items.splice(index, 1);
    }
}

function fillProduct(index) {
    const item = props.form.items[index];

    const product = props.products.find((product) => {
        return Number(product.id) === Number(item.product_id);
    });

    if (product) {
        item.description = product.name;
        item.unit_price = product.sale_price;
    }
}

function lineTotal(item) {
    return money(Number(item.quantity || 0) * Number(item.unit_price || 0));
}

const subtotal = computed(() => {
    let value = 0;

    props.form.items.forEach((item) => {
        value += Number(item.quantity || 0) * Number(item.unit_price || 0);
    });

    return money(value);
});

const total = computed(() => {
    let value = Number(subtotal.value);
    value += Number(props.form.tax_amount || 0);
    value -= Number(props.form.discount_amount || 0);

    return money(value);
});

function money(value) {
    return Number(value || 0).toFixed(2);
}
</script>
