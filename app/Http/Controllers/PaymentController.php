<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function index(): Response
    {
        $payments = Payment::query()
            ->with(['invoice', 'customer'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Payments/Index', [
            'payments' => $payments,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Payments/Create', [
            'customers' => Customer::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'invoices' => Invoice::query()
                ->with('customer')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayment($request);

        DB::transaction(function () use ($validated): void {
            $payment = Payment::create($validated);

            if ($payment->invoice_id) {
                $this->syncInvoicePaymentTotals($payment->invoice);
            }
        });

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment): Response
    {
        $payment->load(['invoice', 'customer']);

        return Inertia::render('Payments/Show', [
            'payment' => $payment,
        ]);
    }

    public function edit(Payment $payment): Response
    {
        return Inertia::render('Payments/Edit', [
            'payment' => $payment,

            'customers' => Customer::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'invoices' => Invoice::query()
                ->with('customer')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $oldInvoice = $payment->invoice;

        $validated = $this->validatePayment($request, $payment->id);

        DB::transaction(function () use ($validated, $payment, $oldInvoice): void {
            $payment->update($validated);

            if ($oldInvoice) {
                $this->syncInvoicePaymentTotals($oldInvoice);
            }

            if ($payment->invoice) {
                $this->syncInvoicePaymentTotals($payment->invoice);
            }
        });

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $invoice = $payment->invoice;

        DB::transaction(function () use ($payment, $invoice): void {
            $payment->delete();

            if ($invoice) {
                $this->syncInvoicePaymentTotals($invoice);
            }
        });

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    private function validatePayment(Request $request, ?int $paymentId = null): array
    {
        return $request->validate([
            'invoice_id' => ['nullable', 'exists:invoices,id'],
            'customer_id' => ['nullable', 'exists:customers,id'],

            'payment_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('payments', 'payment_number')->ignore($paymentId),
            ],

            'payment_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function syncInvoicePaymentTotals(?Invoice $invoice): void
    {
        if (! $invoice) {
            return;
        }

        $paidAmount = $invoice->payments()
            ->where('status', 'completed')
            ->sum('amount');

        $balanceDue = $invoice->total_amount - $paidAmount;

        $status = 'unpaid';

        if ($paidAmount > 0 && $balanceDue > 0) {
            $status = 'partial';
        }

        if ($balanceDue <= 0 && $invoice->total_amount > 0) {
            $status = 'paid';
            $balanceDue = 0;
        }

        $invoice->update([
            'paid_amount' => $paidAmount,
            'balance_due' => $balanceDue,
            'status' => $status,
        ]);
    }
}
