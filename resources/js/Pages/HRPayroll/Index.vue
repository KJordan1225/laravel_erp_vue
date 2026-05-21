<script setup>
import { Link, router } from '@inertiajs/vue3';

defineProps({
    employees: Object,
    departmentsCount: Number,
    employeesCount: Number,
    attendanceCount: Number,
    payrollCount: Number,
});

const deleteEmployee = (id) => {
    if (confirm('Are you sure you want to delete this employee?')) {
        router.delete(route('hr-payroll.destroy', id));
    }
};
</script>

<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold text-primary mb-1">HR Payroll</h1>
                <p class="text-muted mb-0">Manage employees, departments, attendance, and payroll processing.</p>
            </div>

            <Link :href="route('hr-payroll.create')" class="btn btn-orange">
                Add Employee
            </Link>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h6>Departments</h6>
                        <h2>{{ departmentsCount }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h6>Employees</h6>
                        <h2>{{ employeesCount }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h6>Attendance Records</h6>
                        <h2>{{ attendanceCount }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h6>Payroll Runs</h6>
                        <h2>{{ payrollCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <strong>Employees</strong>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Employee #</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Job Title</th>
                            <th>Pay Type</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="employee in employees.data" :key="employee.id">
                            <td>{{ employee.employee_number }}</td>
                            <td>{{ employee.first_name }} {{ employee.last_name }}</td>
                            <td>{{ employee.department?.name ?? 'N/A' }}</td>
                            <td>{{ employee.job_title ?? 'N/A' }}</td>
                            <td class="text-capitalize">{{ employee.pay_type }}</td>
                            <td>
                                <span class="badge" :class="employee.status === 'active' ? 'bg-success' : 'bg-secondary'">
                                    {{ employee.status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <Link :href="route('hr-payroll.show', employee.id)" class="btn btn-sm btn-outline-primary me-1">
                                    View
                                </Link>

                                <Link :href="route('hr-payroll.edit', employee.id)" class="btn btn-sm btn-outline-warning me-1">
                                    Edit
                                </Link>

                                <button @click="deleteEmployee(employee.id)" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="employees.data.length === 0">
                            <td colspan="7" class="text-center text-muted py-4">
                                No employees found.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <Link
                        v-for="link in employees.links"
                        :key="link.label"
                        :href="link.url ?? '#'"
                        class="btn btn-sm"
                        :class="link.active ? 'btn-primary' : 'btn-outline-primary'"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
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

.stat-card {
    border-left: 5px solid #f97316;
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.08);
}

.stat-card h6 {
    color: #0d6efd;
    font-weight: 700;
}

.stat-card h2 {
    color: #f97316;
    font-weight: 800;
}
</style>
