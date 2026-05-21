<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    employee: Object,
    departments: Array,
});

const form = useForm({
    department_id: props.employee.department_id ?? '',
    employee_number: props.employee.employee_number ?? '',
    first_name: props.employee.first_name ?? '',
    last_name: props.employee.last_name ?? '',
    email: props.employee.email ?? '',
    phone: props.employee.phone ?? '',
    job_title: props.employee.job_title ?? '',
    hire_date: props.employee.hire_date ?? '',
    hourly_rate: props.employee.hourly_rate ?? 0,
    salary: props.employee.salary ?? 0,
    pay_type: props.employee.pay_type ?? 'hourly',
    status: props.employee.status ?? 'active',
});

const submit = () => {
    form.put(route('hr-payroll.update', props.employee.id));
};
</script>

<template>
    <div class="container py-4">
        <div class="mb-4">
            <h1 class="fw-bold text-primary">Edit Employee</h1>
            <p class="text-muted">Update HR payroll employee information.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <strong>Edit Employee</strong>
            </div>

            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Employee Number</label>
                            <input v-model="form.employee_number" type="text" class="form-control" />
                            <div class="text-danger small">{{ form.errors.employee_number }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input v-model="form.first_name" type="text" class="form-control" />
                            <div class="text-danger small">{{ form.errors.first_name }}</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input v-model="form.last_name" type="text" class="form-control" />
                            <div class="text-danger small">{{ form.errors.last_name }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input v-model="form.email" type="email" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input v-model="form.phone" type="text" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select v-model="form.department_id" class="form-select">
                                <option value="">No Department</option>
                                <option v-for="department in departments" :key="department.id" :value="department.id">
                                    {{ department.name }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Job Title</label>
                            <input v-model="form.job_title" type="text" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Hire Date</label>
                            <input v-model="form.hire_date" type="date" class="form-control" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Pay Type</label>
                            <select v-model="form.pay_type" class="form-select">
                                <option value="hourly">Hourly</option>
                                <option value="salary">Salary</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select v-model="form.status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Hourly Rate</label>
                            <input v-model="form.hourly_rate" type="number" step="0.01" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Salary</label>
                            <input v-model="form.salary" type="number" step="0.01" class="form-control" />
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-orange" :disabled="form.processing">
                            Update Employee
                        </button>

                        <Link :href="route('hr-payroll.index')" class="btn btn-outline-secondary">
                            Cancel
                        </Link>
                    </div>
                </form>
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
</style>
