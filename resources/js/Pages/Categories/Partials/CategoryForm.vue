<template>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Category Name</label>
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
            <label class="form-label">Category Type</label>
            <select
                v-model="form.type"
                class="form-select"
                :class="{ 'is-invalid': form.errors.type }"
            >
                <option value="product">Product</option>
                <option value="expense">Expense</option>
                <option value="general">General</option>
            </select>

            <div v-if="form.errors.type" class="invalid-feedback">
                {{ form.errors.type }}
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
                    Active Category
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
});
</script>
