<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\SalesOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    public function index(): Response
    {
        $invoices = Invoice::query()
            ->with(['customer', 'salesOrder'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Invoices/Create', [
            'customers' => Customer::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'salesOrders' => SalesOrder::query()
                ->with('customer')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateInvoice($request);

        $validated['balance_due'] = $validated['total_amount'] - $validated['paid_amount'];

        Invoice::create($validated);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice): Response
    {
        $invoice->load(['customer', 'salesOrder', 'payments']);

        return Inertia::render('Invoices/Show', [
            'invoice' => $invoice,
        ]);
    }

    public function edit(Invoice $invoice): Response
    {
        return Inertia::render('Invoices/Edit', [
            'invoice' => $invoice,

            'customers' => Customer::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'salesOrders' => SalesOrder::query()
                ->with('customer')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $this->validateInvoice($request, $invoice->id);

        $validated['balance_due'] = $validated['total_amount'] - $validated['paid_amount'];

        if ($validated['balance_due'] <= 0) {
            $validated['status'] = 'paid';
        }

        $invoice->update($validated);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    private function validateInvoice(Request $request, ?int $invoiceId = null): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'sales_order_id' => ['nullable', 'exists:sales_orders,id'],

            'invoice_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('invoices', 'invoice_number')->ignore($invoiceId),
            ],

            'invoice_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date'],

            'subtotal' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['required', 'numeric', 'min:0'],

            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
