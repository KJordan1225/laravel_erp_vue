<template>
    <ErpLayout title="Create Category">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Create Category</h1>
                <p class="text-muted mb-0">Add a new ERP category.</p>
            </div>

            <Link href="/categories" class="btn btn-outline-primary">
                Back to Categories
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Category Information
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <CategoryForm :form="form" />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/categories" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import CategoryForm from './Partials/CategoryForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    type: 'product',
    description: '',
    is_active: true,
});

function submit() {
    form.post('/categories');
}
</script>
