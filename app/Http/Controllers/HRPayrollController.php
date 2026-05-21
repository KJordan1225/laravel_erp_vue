<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HRPayrollController extends Controller
{
    public function index()
    {
        return Inertia::render('HRPayroll/Index', [
            'employees' => Employee::with('department')
                ->latest()
                ->paginate(10),

            'departmentsCount' => Department::count(),
            'employeesCount' => Employee::count(),
            'attendanceCount' => Attendance::count(),
            'payrollCount' => Payroll::count(),
        ]);
    }

    public function create()
    {
        return Inertia::render('HRPayroll/Create', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateEmployee($request);

        Employee::create($validated);

        return redirect()->route('hr-payroll.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'attendances', 'payrolls']);

        return Inertia::render('HRPayroll/Show', [
            'employee' => $employee,
        ]);
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('HRPayroll/Edit', [
            'employee' => $employee,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $this->validateEmployee($request, $employee->id);

        $employee->update($validated);

        return redirect()->route('hr-payroll.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('hr-payroll.index')
            ->with('success', 'Employee deleted successfully.');
    }

    private function validateEmployee(Request $request, ?int $employeeId = null): array
    {
        return $request->validate([
            'department_id' => ['nullable', 'exists:departments,id'],
            'employee_number' => ['required', 'string', 'max:255', 'unique:employees,employee_number,' . $employeeId],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['nullable', 'date'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'pay_type' => ['required', 'in:hourly,salary'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }
}