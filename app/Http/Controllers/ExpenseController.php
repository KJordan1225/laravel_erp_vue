<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseController extends Controller
{
    public function index(): Response
    {
        $expenses = Expense::query()
            ->with('vendor')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Expenses/Index', [
            'expenses' => $expenses,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Expenses/Create', [
            'vendors' => Vendor::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'categories' => Category::query()
                ->whereIn('type', ['expense', 'general'])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateExpense($request);

        Expense::create($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense): Response
    {
        $expense->load('vendor');

        return Inertia::render('Expenses/Show', [
            'expense' => $expense,
        ]);
    }

    public function edit(Expense $expense): Response
    {
        return Inertia::render('Expenses/Edit', [
            'expense' => $expense,

            'vendors' => Vendor::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'categories' => Category::query()
                ->whereIn('type', ['expense', 'general'])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $this->validateExpense($request, $expense->id);

        $expense->update($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    private function validateExpense(Request $request, ?int $expenseId = null): array
    {
        return $request->validate([
            'vendor_id' => ['nullable', 'exists:vendors,id'],

            'expense_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('expenses', 'expense_number')->ignore($expenseId),
            ],

            'category' => ['nullable', 'string', 'max:100'],
            'expense_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
