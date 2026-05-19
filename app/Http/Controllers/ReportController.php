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

class ReportController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Reports/Index', [
            'summary' => [
                'customers' => Customer::count(),
                'vendors' => Vendor::count(),
                'products' => Product::count(),

                'salesOrders' => SalesOrder::count(),
                'salesTotal' => SalesOrder::sum('total_amount'),

                'purchaseOrders' => PurchaseOrder::count(),
                'purchaseTotal' => PurchaseOrder::sum('total_amount'),

                'invoices' => Invoice::count(),
                'invoiceTotal' => Invoice::sum('total_amount'),
                'invoiceBalanceDue' => Invoice::sum('balance_due'),

                'payments' => Payment::count(),
                'paymentTotal' => Payment::where('status', 'completed')->sum('amount'),

                'expenses' => Expense::count(),
                'expenseTotal' => Expense::sum('amount'),
            ],

            'recentSalesOrders' => SalesOrder::query()
                ->with('customer')
                ->latest()
                ->take(10)
                ->get(),

            'recentPurchaseOrders' => PurchaseOrder::query()
                ->with('vendor')
                ->latest()
                ->take(10)
                ->get(),

            'recentInvoices' => Invoice::query()
                ->with('customer')
                ->latest()
                ->take(10)
                ->get(),

            'recentPayments' => Payment::query()
                ->with(['customer', 'invoice'])
                ->latest()
                ->take(10)
                ->get(),

            'recentExpenses' => Expense::query()
                ->with('vendor')
                ->latest()
                ->take(10)
                ->get(),

            'lowStockProducts' => Product::query()
                ->whereColumn('stock_quantity', '<=', 'reorder_level')
                ->orderBy('stock_quantity')
                ->take(20)
                ->get(),
        ]);
    }
}
