<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InventoryController extends Controller
{
    public function index(): Response
    {
        $inventoryItems = InventoryItem::query()
            ->with('product')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Inventory/Index', [
            'inventoryItems' => $inventoryItems,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Inventory/Create', [
            'products' => Product::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'movement_type' => ['required', 'string', 'in:in,out,adjustment'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $inventoryItem = InventoryItem::create($validated);

        $this->applyStockMovement($inventoryItem);

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory movement created successfully.');
    }

    public function show(InventoryItem $inventory): Response
    {
        $inventory->load('product');

        return Inertia::render('Inventory/Show', [
            'inventoryItem' => $inventory,
        ]);
    }

    public function edit(InventoryItem $inventory): Response
    {
        return Inertia::render('Inventory/Edit', [
            'inventoryItem' => $inventory,

            'products' => Product::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Request $request, InventoryItem $inventory): RedirectResponse
    {
        $this->reverseStockMovement($inventory);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'movement_type' => ['required', 'string', 'in:in,out,adjustment'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $inventory->update($validated);

        $this->applyStockMovement($inventory);

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory movement updated successfully.');
    }

    public function destroy(InventoryItem $inventory): RedirectResponse
    {
        $this->reverseStockMovement($inventory);

        $inventory->delete();

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory movement deleted successfully.');
    }

    private function applyStockMovement(InventoryItem $inventoryItem): void
    {
        $product = $inventoryItem->product;

        if (! $product) {
            return;
        }

        if ($inventoryItem->movement_type === 'in') {
            $product->increment('stock_quantity', $inventoryItem->quantity);
        }

        if ($inventoryItem->movement_type === 'out') {
            $product->decrement('stock_quantity', $inventoryItem->quantity);
        }

        if ($inventoryItem->movement_type === 'adjustment') {
            $product->update([
                'stock_quantity' => $inventoryItem->quantity,
            ]);
        }
    }

    private function reverseStockMovement(InventoryItem $inventoryItem): void
    {
        $product = $inventoryItem->product;

        if (! $product) {
            return;
        }

        if ($inventoryItem->movement_type === 'in') {
            $product->decrement('stock_quantity', $inventoryItem->quantity);
        }

        if ($inventoryItem->movement_type === 'out') {
            $product->increment('stock_quantity', $inventoryItem->quantity);
        }

        if ($inventoryItem->movement_type === 'adjustment') {
            /*
             * Adjustment records set stock to a fixed number.
             * Reversing an adjustment perfectly would require storing the previous stock.
             * For this beginner ERP, deletion/update simply removes the adjustment record.
             */
        }
    }
}
