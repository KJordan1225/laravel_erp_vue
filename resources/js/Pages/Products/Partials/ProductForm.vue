<template>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input
                v-model="form.name"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.name }"
            >

            <div v-if="form.errors.name" class="invalid-feedback">
                {{ form.errors.name }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">SKU</label>
            <input
                v-model="form.sku"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.sku }"
            >

            <div v-if="form.errors.sku" class="invalid-feedback">
                {{ form.errors.sku }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Category</label>
            <select
                v-model="form.category_id"
                class="form-select"
                :class="{ 'is-invalid': form.errors.category_id }"
            >
                <option :value="null">No Category</option>

                <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                >
                    {{ category.name }}
                </option>
            </select>

            <div v-if="form.errors.category_id" class="invalid-feedback">
                {{ form.errors.category_id }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Vendor</label>
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

        <div class="col-md-3">
            <label class="form-label">Purchase Price</label>
            <input
                v-model="form.purchase_price"
                type="number"
                step="0.01"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.purchase_price }"
            >

            <div v-if="form.errors.purchase_price" class="invalid-feedback">
                {{ form.errors.purchase_price }}
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Sale Price</label>
            <input
                v-model="form.sale_price"
                type="number"
                step="0.01"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.sale_price }"
            >

            <div v-if="form.errors.sale_price" class="invalid-feedback">
                {{ form.errors.sale_price }}
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Stock Quantity</label>
            <input
                v-model="form.stock_quantity"
                type="number"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.stock_quantity }"
            >

            <div v-if="form.errors.stock_quantity" class="invalid-feedback">
                {{ form.errors.stock_quantity }}
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Reorder Level</label>
            <input
                v-model="form.reorder_level"
                type="number"
                min="0"
                class="form-control"
                :class="{ 'is-invalid': form.errors.reorder_level }"
            >

            <div v-if="form.errors.reorder_level" class="invalid-feedback">
                {{ form.errors.reorder_level }}
            </div>
        </div>

        <div class="col-md-6 d-flex align-items-end">
            <div class="form-check">
                <input
                    id="is_active"
                    v-model="form.is_active"
                    type="checkbox"
                    class="form-check-input"
                >

                <label for="is_active" class="form-check-label">
                    Active Product
                </label>
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
    categories: {
        type: Array,
        default: () => [],
    },
    vendors: {
        type: Array,
        default: () => [],
    },
});
</script>
