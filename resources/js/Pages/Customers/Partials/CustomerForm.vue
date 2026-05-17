<template>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Customer Name</label>
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
            <label class="form-label">Company Name</label>
            <input
                v-model="form.company_name"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.company_name }"
            >
            <div v-if="form.errors.company_name" class="invalid-feedback">
                {{ form.errors.company_name }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input
                v-model="form.email"
                type="email"
                class="form-control"
                :class="{ 'is-invalid': form.errors.email }"
            >
            <div v-if="form.errors.email" class="invalid-feedback">
                {{ form.errors.email }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input
                v-model="form.phone"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.phone }"
            >
            <div v-if="form.errors.phone" class="invalid-feedback">
                {{ form.errors.phone }}
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">Address</label>
            <input
                v-model="form.address"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.address }"
            >
            <div v-if="form.errors.address" class="invalid-feedback">
                {{ form.errors.address }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">City</label>
            <input
                v-model="form.city"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.city }"
            >
            <div v-if="form.errors.city" class="invalid-feedback">
                {{ form.errors.city }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">State</label>
            <input
                v-model="form.state"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.state }"
            >
            <div v-if="form.errors.state" class="invalid-feedback">
                {{ form.errors.state }}
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Postal Code</label>
            <input
                v-model="form.postal_code"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.postal_code }"
            >
            <div v-if="form.errors.postal_code" class="invalid-feedback">
                {{ form.errors.postal_code }}
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Country</label>
            <input
                v-model="form.country"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.country }"
            >
            <div v-if="form.errors.country" class="invalid-feedback">
                {{ form.errors.country }}
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
                    Active Customer
                </label>
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
});
</script>
