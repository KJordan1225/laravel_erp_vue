<template>
    <ErpLayout title="Vendor Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Vendor Details</h1>
                <p class="text-muted mb-0">View vendor information.</p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/vendors" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/vendors/${vendor.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                {{ vendor.name }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ vendor.name }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Company:</strong>
                        <div>{{ vendor.company_name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <div>{{ vendor.email || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Phone:</strong>
                        <div>{{ vendor.phone || '-' }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Website:</strong>
                        <div>{{ vendor.website || '-' }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Address:</strong>
                        <div>
                            {{ vendor.address || '-' }}
                            <span v-if="vendor.city">, {{ vendor.city }}</span>
                            <span v-if="vendor.state">, {{ vendor.state }}</span>
                            <span v-if="vendor.postal_code"> {{ vendor.postal_code }}</span>
                            <span v-if="vendor.country">, {{ vendor.country }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span v-if="vendor.is_active" class="badge bg-success">
                                Active
                            </span>

                            <span v-else class="badge bg-secondary">
                                Inactive
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <strong>Notes:</strong>
                        <div>{{ vendor.notes || '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    vendor: {
        type: Object,
        required: true,
    },
});
</script>
