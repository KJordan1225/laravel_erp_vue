<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SalesOrderController extends Controller
{
    public function index(): Response
    {
        $salesOrders = SalesOrder::query()
            ->with('customer')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SalesOrders/Index', [
            'salesOrders' => $salesOrders,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('SalesOrders/Create', [
            'customers' => Customer::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'products' => Product::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSalesOrder($request);

        DB::transaction(function () use ($validated): void {
            $totals = $this->calculateTotals($validated);

            $salesOrder = SalesOrder::create([
                'customer_id' => $validated['customer_id'],
                'order_number' => $validated['order_number'],
                'order_date' => $validated['order_date'],
                'due_date' => $validated['due_date'] ?? null,
                'subtotal' => $totals['subtotal'],
                'tax_amount' => $totals['tax_amount'],
                'discount_amount' => $totals['discount_amount'],
                'total_amount' => $totals['total_amount'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];

                $salesOrder->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $lineTotal,
                ]);

                if (! empty($item['product_id'])) {
                    Product::where('id', $item['product_id'])
                        ->decrement('stock_quantity', $item['quantity']);
                }
            }
        });

        return redirect()
            ->route('sales-orders.index')
            ->with('success', 'Sales order created successfully.');
    }

    public function show(SalesOrder $salesOrder): Response
    {
        $salesOrder->load(['customer', 'items.product']);

        return Inertia::render('SalesOrders/Show', [
            'salesOrder' => $salesOrder,
        ]);
    }

    public function edit(SalesOrder $salesOrder): Response
    {
        $salesOrder->load('items');

        return Inertia::render('SalesOrders/Edit', [
            'salesOrder' => $salesOrder,

            'customers' => Customer::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'products' => Product::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Request $request, SalesOrder $salesOrder): RedirectResponse
    {
        $validated = $this->validateSalesOrder($request, $salesOrder->id);

        DB::transaction(function () use ($validated, $salesOrder): void {
            foreach ($salesOrder->items as $oldItem) {
                if ($oldItem->product_id) {
                    Product::where('id', $oldItem->product_id)
                        ->increment('stock_quantity', $oldItem->quantity);
                }
            }

            $salesOrder->items()->delete();

            $totals = $this->calculateTotals($validated);

            $salesOrder->update([
                'customer_id' => $validated['customer_id'],
                'order_number' => $validated['order_number'],
                'order_date' => $validated['order_date'],
                'due_date' => $validated['due_date'] ?? null,
                'subtotal' => $totals['subtotal'],
                'tax_amount' => $totals['tax_amount'],
                'discount_amount' => $totals['discount_amount'],
                'total_amount' => $totals['total_amount'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];

                $salesOrder->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $lineTotal,
                ]);

                if (! empty($item['product_id'])) {
                    Product::where('id', $item['product_id'])
                        ->decrement('stock_quantity', $item['quantity']);
                }
            }
        });

        return redirect()
            ->route('sales-orders.index')
            ->with('success', 'Sales order updated successfully.');
    }

    public function destroy(SalesOrder $salesOrder): RedirectResponse
    {
        DB::transaction(function () use ($salesOrder): void {
            $salesOrder->load('items');

            foreach ($salesOrder->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->increment('stock_quantity', $item->quantity);
                }
            }

            $salesOrder->delete();
        });

        return redirect()
            ->route('sales-orders.index')
            ->with('success', 'Sales order deleted successfully.');
    }

    private function validateSalesOrder(Request $request, ?int $salesOrderId = null): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'order_number' => [
                'required',
                'string',
                'max:100',
                'unique:sales_orders,order_number,' . $salesOrderId,
            ],
            'order_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date'],
            'tax_amount' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'exists:products,id'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);
    }

    private function calculateTotals(array $validated): array
    {
        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $taxAmount = $validated['tax_amount'];
        $discountAmount = $validated['discount_amount'];
        $totalAmount = $subtotal + $taxAmount - $discountAmount;

        return [
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
        ];
    }
}
