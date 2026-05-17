<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\Vendor;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'customers' => Customer::count(),
                'vendors' => Vendor::count(),
                'products' => Product::count(),
                'salesOrders' => SalesOrder::count(),
                'purchaseOrders' => PurchaseOrder::count(),
                'invoices' => Invoice::count(),
                'paymentsTotal' => Payment::sum('amount'),
                'expensesTotal' => Expense::sum('amount'),
            ],

            'recentInvoices' => Invoice::with('customer')
                ->latest()
                ->take(5)
                ->get(),

            'recentSalesOrders' => SalesOrder::with('customer')
                ->latest()
                ->take(5)
                ->get(),

            'lowStockProducts' => Product::query()
                ->whereColumn('stock_quantity', '<=', 'reorder_level')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
