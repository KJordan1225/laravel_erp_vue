<template>
    <ErpLayout title="Vendors">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Vendors</h1>
                <p class="text-muted mb-0">Manage suppliers and service providers.</p>
            </div>

            <Link href="/vendors/create" class="btn btn-erp-orange">
                Add Vendor
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Vendor List
            </div>

            <div class="erp-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th width="260">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="vendor in vendors.data" :key="vendor.id">
                                <td>{{ vendor.name }}</td>
                                <td>{{ vendor.company_name || '-' }}</td>
                                <td>{{ vendor.email || '-' }}</td>
                                <td>{{ vendor.phone || '-' }}</td>
                                <td>
                                    <span
                                        v-if="vendor.is_active"
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
                                            :href="`/vendors/${vendor.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/vendors/${vendor.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteVendor(vendor)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="vendors.data.length === 0">
                                <td colspan="6" class="text-center text-muted">
                                    No vendors found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ vendors.current_page }} of {{ vendors.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="vendors.prev_page_url"
                            :href="vendors.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="vendors.next_page_url"
                            :href="vendors.next_page_url"
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
    vendors: {
        type: Object,
        required: true,
    },
});

function deleteVendor(vendor) {
    if (window.confirm(`Delete vendor "${vendor.name}"?`)) {
        router.delete(`/vendors/${vendor.id}`);
    }
}
</script>
