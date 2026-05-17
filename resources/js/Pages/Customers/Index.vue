<template>
    <ErpLayout title="Customers">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="erp-page-title mb-1">Customers</h1>
                <p class="text-muted mb-0">Manage your customer records.</p>
            </div>

            <Link href="/customers/create" class="btn btn-erp-orange">
                Add Customer
            </Link>
        </div>

        <div class="erp-card">
            <div class="erp-card-header">
                Customer List
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
                            <tr v-for="customer in customers.data" :key="customer.id">
                                <td>{{ customer.name }}</td>
                                <td>{{ customer.company_name || '-' }}</td>
                                <td>{{ customer.email || '-' }}</td>
                                <td>{{ customer.phone || '-' }}</td>
                                <td>
                                    <span
                                        v-if="customer.is_active"
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
                                            :href="`/customers/${customer.id}`"
                                            class="btn btn-sm btn-primary"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="`/customers/${customer.id}/edit`"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            @click="deleteCustomer(customer)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="customers.data.length === 0">
                                <td colspan="6" class="text-center text-muted">
                                    No customers found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing page {{ customers.current_page }} of {{ customers.last_page }}
                    </div>

                    <div class="d-flex gap-2">
                        <Link
                            v-if="customers.prev_page_url"
                            :href="customers.prev_page_url"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Previous
                        </Link>

                        <Link
                            v-if="customers.next_page_url"
                            :href="customers.next_page_url"
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
    customers: {
        type: Object,
        required: true,
    },
});

function deleteCustomer(customer) {
    if (window.confirm(`Delete customer "${customer.name}"?`)) {
        router.delete(`/customers/${customer.id}`);
    }
}
</script>
