<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    employee: Object,
});

const deleteEmployee = () => {
    if (confirm('Are you sure you want to delete this employee?')) {
        router.delete(route('hr-payroll.destroy', props.employee.id));
    }
};
</script>

<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold text-primary">
                    {{ employee.first_name }} {{ employee.last_name }}
                </h1>
                <p class="text-muted mb-0">Employee HR payroll profile.</p>
            </div>

            <div>
                <Link :href="route('hr-payroll.edit', employee.id)" class="btn btn-orange me-2">
                    Edit
                </Link>

                <button @click="deleteEmployee" class="btn btn-outline-danger">
                    Delete
                </button>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Employee Details</strong>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <strong>Employee #:</strong>
                        <div>{{ employee.employee_number }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Department:</strong>
                        <div>{{ employee.department?.name ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Job Title:</strong>
                        <div>{{ employee.job_title ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Email:</strong>
                        <div>{{ employee.email ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Phone:</strong>
                        <div>{{ employee.phone ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Status:</strong>
                        <div class="text-capitalize">{{ employee.status }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Pay Type:</strong>
                        <div class="text-capitalize">{{ employee.pay_type }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Hourly Rate:</strong>
                        <div>${{ employee.hourly_rate }}</div>
                    </div>

                    <div class="col-md-4">
                        <strong>Salary:</strong>
                        <div>${{ employee.salary }}</div>
                    </div>
                </div>
            </div>
        </div>

        <Link :href="route('hr-payroll.index')" class="btn btn-outline-primary">
            Back to HR Payroll
        </Link>
    </div>
</template>

<style scoped>
.btn-orange {
    background-color: #f97316;
    color: white;
    border: none;
}

.btn-orange:hover {
    background-color: #ea580c;
    color: white;
}
</style>
