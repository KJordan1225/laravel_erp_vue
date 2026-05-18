<template>
    <ErpLayout title="Edit Category">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Edit Category</h1>
                <p class="text-muted mb-0">Update category information.</p>
            </div>

            <Link href="/categories" class="btn btn-outline-primary">
                Back to Categories
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Edit {{ category.name }}
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
                            Update Category
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

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.category.name || '',
    type: props.category.type || 'product',
    description: props.category.description || '',
    is_active: Boolean(props.category.is_active),
});

function submit() {
    form.put(`/categories/${props.category.id}`);
}
</script>
