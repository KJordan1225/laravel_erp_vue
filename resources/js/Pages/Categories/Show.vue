<template>
    <ErpLayout title="Category Details">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Category Details</h1>
                <p class="text-muted mb-0">View category information.</p>
            </div>

            <div class="d-flex gap-2">
                <Link href="/categories" class="btn btn-outline-primary">
                    Back
                </Link>

                <Link
                    :href="`/categories/${category.id}/edit`"
                    class="btn btn-erp-orange"
                >
                    Edit
                </Link>
            </div>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                {{ category.name }}
            </div>

            <div class="erp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ category.name }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Type:</strong>
                        <div>
                            <span class="badge bg-primary">
                                {{ category.type }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>
                            <span v-if="category.is_active" class="badge bg-success">
                                Active
                            </span>

                            <span v-else class="badge bg-secondary">
                                Inactive
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <strong>Description:</strong>
                        <div>{{ category.description || '-' }}</div>
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
    category: {
        type: Object,
        required: true,
    },
});
</script>
