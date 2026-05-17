<template>
    <ErpLayout title="Customer Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Customer Details</h1>
                <p class="text-muted mb-0">View customer information.</p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/customers" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/customers/${customer.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                {{ customer.name }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ customer.name }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Company:</strong>
                        <div>{{ customer.company_name || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <div>{{ customer.email || '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Phone:</strong>
                        <div>{{ customer.phone || '-' }}</div>
                    </div>

                    <div class="col-md-12">
                        <strong>Address:</strong>
                        <div>
                            {{ customer.address || '-' }}
                            <span v-if="customer.city">, {{ customer.city }}</span>
                            <span v-if="customer.state">, {{ customer.state }}</span>
                            <span v-if="customer.postal_code"> {{ customer.postal_code }}</span>
                            <span v-if="customer.country">, {{ customer.country }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span v-if="customer.is_active" class="badge bg-success">
                                Active
                            </span>

                            <span v-else class="badge bg-secondary">
                                Inactive
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <strong>Notes:</strong>
                        <div>{{ customer.notes || '-' }}</div>
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
    customer: {
        type: Object,
        required: true,
    },
});
</script>
