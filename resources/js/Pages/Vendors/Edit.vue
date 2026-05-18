<template>
    <ErpLayout title="Edit Vendor">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Vendor</h1>
                <p class="text-muted mb-0">Update vendor information.</p>
            </div>

            <Link href="/vendors" class="btn btn-outline-primary">
                Back to Vendors
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ vendor.name }}
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <VendorForm :form="form" />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/vendors" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Update Vendor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import VendorForm from './Partials/VendorForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    vendor: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.vendor.name || '',
    company_name: props.vendor.company_name || '',
    email: props.vendor.email || '',
    phone: props.vendor.phone || '',
    website: props.vendor.website || '',
    address: props.vendor.address || '',
    city: props.vendor.city || '',
    state: props.vendor.state || '',
    postal_code: props.vendor.postal_code || '',
    country: props.vendor.country || 'USA',
    notes: props.vendor.notes || '',
    is_active: Boolean(props.vendor.is_active),
});

function submit() {
    form.put(`/vendors/${props.vendor.id}`);
}
</script>
