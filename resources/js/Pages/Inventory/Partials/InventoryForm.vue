<template>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Product</label>

            <select
                v-model="form.product_id"
                class="form-select"
                :class="{ 'is-invalid': form.errors.product_id }"
            >
                <option :value="null">Select Product</option>

                <option
                    v-for="product in products"
                    :key="product.id"
                    :value="product.id"
                >
                    {{ product.name }} — {{ product.sku }}
                </option>
            </select>

            <div v-if="form.errors.product_id" class="invalid-feedback">
                {{ form.errors.product_id }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Movement Type</label>

            <select
                v-model="form.movement_type"
                class="form-select"
                :class="{ 'is-invalid': form.errors.movement_type }"
            >
                <option value="in">Stock In</option>
                <option value="out">Stock Out</option>
                <option value="adjustment">Adjustment</option>
            </select>

            <div v-if="form.errors.movement_type" class="invalid-feedback">
                {{ form.errors.movement_type }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">
                Quantity
            </label>

            <input
                v-model="form.quantity"
                type="number"
                min="1"
                class="form-control"
                :class="{ 'is-invalid': form.errors.quantity }"
            >

            <div class="form-text">
                For adjustment, this becomes the new total stock quantity.
            </div>

            <div v-if="form.errors.quantity" class="invalid-feedback">
                {{ form.errors.quantity }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Reference</label>

            <input
                v-model="form.reference"
                type="text"
                class="form-control"
                placeholder="Example: PO-1001, SO-1001"
                :class="{ 'is-invalid': form.errors.reference }"
            >

            <div v-if="form.errors.reference" class="invalid-feedback">
                {{ form.errors.reference }}
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
defineProps({
    form: {
        type: Object,
        required: true,
    },
    products: {
        type: Array,
        default: () => [],
    },
});
</script>
