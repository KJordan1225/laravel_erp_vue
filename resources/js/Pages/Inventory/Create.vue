<template>
    <ErpLayout title="Create Inventory Movement">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">
                    Create Inventory Movement
                </h1>
                <p class="text-muted mb-0">
                    Add stock in, stock out, or an inventory adjustment.
                </p>
            </div>

            <Link href="/inventory" class="btn btn-outline-primary">
                Back to Inventory
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Inventory Movement
            </div>

            <div class="erp-card-body">
                <form @submit.prevent="submit">
                    <InventoryForm
                        :form="form"
                        :products="products"
                    />

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <Link href="/inventory" class="btn btn-outline-secondary">
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            class="btn btn-erp-orange"
                            :disabled="form.processing"
                        >
                            Save Movement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </ErpLayout>
</template>

<script setup>
import ErpLayout from '@/Layouts/ErpLayout.vue';
import InventoryForm from './Partials/InventoryForm.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    product_id: null,
    movement_type: 'in',
    quantity: 1,
    reference: '',
    notes: '',
});

function submit() {
    form.post('/inventory');
}
</script>
