<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseOrderController extends Controller
{
    public function index(): Response
    {
        $purchaseOrders = PurchaseOrder::query()
            ->with('vendor')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('PurchaseOrders/Index', [
            'purchaseOrders' => $purchaseOrders,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('PurchaseOrders/Create', [
            'vendors' => Vendor::query()
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
        $validated = $this->validatePurchaseOrder($request);

        DB::transaction(function () use ($validated): void {
            $totals = $this->calculateTotals($validated);

            $purchaseOrder = PurchaseOrder::create([
                'vendor_id' => $validated['vendor_id'],
                'purchase_order_number' => $validated['purchase_order_number'],
                'order_date' => $validated['order_date'],
                'expected_date' => $validated['expected_date'] ?? null,
                'subtotal' => $totals['subtotal'],
                'tax_amount' => $totals['tax_amount'],
                'discount_amount' => $totals['discount_amount'],
                'total_amount' => $totals['total_amount'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $lineTotal = $item['quantity'] * $item['unit_cost'];

                $purchaseOrder->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'line_total' => $lineTotal,
                ]);

                if (! empty($item['product_id'])) {
                    Product::where('id', $item['product_id'])
                        ->increment('stock_quantity', $item['quantity']);
                }
            }
        });

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder): Response
    {
        $purchaseOrder->load(['vendor', 'items.product']);

        return Inertia::render('PurchaseOrders/Show', [
            'purchaseOrder' => $purchaseOrder,
        ]);
    }

    public function edit(PurchaseOrder $purchaseOrder): Response
    {
        $purchaseOrder->load('items');

        return Inertia::render('PurchaseOrders/Edit', [
            'purchaseOrder' => $purchaseOrder,

            'vendors' => Vendor::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'products' => Product::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $validated = $this->validatePurchaseOrder($request, $purchaseOrder->id);

        DB::transaction(function () use ($validated, $purchaseOrder): void {
            foreach ($purchaseOrder->items as $oldItem) {
                if ($oldItem->product_id) {
                    Product::where('id', $oldItem->product_id)
                        ->decrement('stock_quantity', $oldItem->quantity);
                }
            }

            $purchaseOrder->items()->delete();

            $totals = $this->calculateTotals($validated);

            $purchaseOrder->update([
                'vendor_id' => $validated['vendor_id'],
                'purchase_order_number' => $validated['purchase_order_number'],
                'order_date' => $validated['order_date'],
                'expected_date' => $validated['expected_date'] ?? null,
                'subtotal' => $totals['subtotal'],
                'tax_amount' => $totals['tax_amount'],
                'discount_amount' => $totals['discount_amount'],
                'total_amount' => $totals['total_amount'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $lineTotal = $item['quantity'] * $item['unit_cost'];

                $purchaseOrder->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'line_total' => $lineTotal,
                ]);

                if (! empty($item['product_id'])) {
                    Product::where('id', $item['product_id'])
                        ->increment('stock_quantity', $item['quantity']);
                }
            }
        });

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        DB::transaction(function () use ($purchaseOrder): void {
            $purchaseOrder->load('items');

            foreach ($purchaseOrder->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->decrement('stock_quantity', $item->quantity);
                }
            }

            $purchaseOrder->delete();
        });

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    private function validatePurchaseOrder(Request $request, ?int $purchaseOrderId = null): array
    {
        return $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'purchase_order_number' => [
                'required',
                'string',
                'max:100',
                'unique:purchase_orders,purchase_order_number,' . $purchaseOrderId,
            ],
            'order_date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date'],
            'tax_amount' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'exists:products,id'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ]);
    }

    private function calculateTotals(array $validated): array
    {
        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $subtotal += $item['quantity'] * $item['unit_cost'];
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
