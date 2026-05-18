<template>
    <ErpLayout title="Categories">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Categories</h1>
                <p class="text-muted mb-0">Organize products, expenses, and ERP records.</p>
            </div>

            <Link href="/categories/create" class="btn btn-erp-orange">
                Add Category
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Category List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="category in categories.data" :key="category.id">
                                <td>{{ category.name }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ category.type }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        v-if="category.is_active"
                                        class="badge bg-success"
                                    >
                                        Active
                                    </span>

                                    <span
                                        v-else
                                        class="badge bg-secondary"
                                    >
                                        Inactive
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <Link
                                            :href="`/categories/${category.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/categories/${category.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteCategory(category)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="categories.data.length === 0">
                                <td colspan="4" class="text-center text-muted">
                                    No categories found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ categories.current_page }} of {{ categories.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="categories.prev_page_url"
                            :href="categories.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="categories.next_page_url"
                            :href="categories.next_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Next
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    categories: {
        type: Object,
        required: true,
    },
});

function deleteCategory(category) {
    if (window.confirm(`Delete category "${category.name}"?`)) {
        router.delete(`/categories/${category.id}`);
    }
}
</script>
