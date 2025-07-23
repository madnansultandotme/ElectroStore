<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * Display main analytics dashboard.
     */
    public function index()
    {
        // Date range for reports (last 30 days by default)
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        
        // Key metrics
        $metrics = [
            'total_revenue' => Order::where('created_at', '>=', $startDate)->sum('total_price'),
            'total_orders' => Order::where('created_at', '>=', $startDate)->count(),
            'new_customers' => User::where('created_at', '>=', $startDate)->where('is_admin', false)->count(),
            'average_order_value' => Order::where('created_at', '>=', $startDate)->avg('total_price') ?? 0,
        ];
        
        // Daily sales for chart
        $dailySales = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as revenue, COUNT(*) as orders')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top selling products
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $startDate)
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        // Category performance
        $categoryStats = DB::table('categories')
            ->select('categories.name', DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $startDate)
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->get();
        
        return view('admin.reports.index', compact(
            'metrics', 'dailySales', 'topProducts', 'categoryStats', 'startDate', 'endDate'
        ));
    }
    
    /**
     * Sales report with date filtering.
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->toDateString());
        
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $summary = [
            'total_revenue' => Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_price'),
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'average_order' => Order::whereBetween('created_at', [$startDate, $endDate])->avg('total_price') ?? 0,
        ];
        
        return view('admin.reports.sales', compact('orders', 'summary', 'startDate', 'endDate'));
    }
    
    /**
     * Inventory report.
     */
    public function inventory()
    {
        $lowStockProducts = Product::lowStock()->with('category')->get();
        $outOfStockProducts = Product::where('stock', 0)->with('category')->get();
        $totalProducts = Product::count();
        $totalStockValue = Product::selectRaw('SUM(stock * COALESCE(cost_price, price)) as total')
            ->first()->total ?? 0;
        
        $inventoryStats = [
            'total_products' => $totalProducts,
            'low_stock_count' => $lowStockProducts->count(),
            'out_of_stock_count' => $outOfStockProducts->count(),
            'total_stock_value' => $totalStockValue,
        ];
        
        return view('admin.reports.inventory', compact(
            'lowStockProducts', 'outOfStockProducts', 'inventoryStats'
        ));
    }
    
    /**
     * Customer analytics.
     */
    public function customers()
    {
        $topCustomers = User::select('users.*', DB::raw('COUNT(orders.id) as order_count'), DB::raw('SUM(orders.total_price) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.is_admin', false)
            ->groupBy('users.id')
            ->orderBy('total_spent', 'desc')
            ->limit(20)
            ->get();
        
        $customerStats = [
            'total_customers' => User::where('is_admin', false)->count(),
            'customers_with_orders' => User::whereHas('orders')->where('is_admin', false)->count(),
            'new_customers_this_month' => User::where('is_admin', false)
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->count(),
        ];
        
        return view('admin.reports.customers', compact('topCustomers', 'customerStats'));
    }
    
    /**
     * Product performance report.
     */
    public function products(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->toDateString());
        
        $products = Product::select('products.*')
            ->withCount(['orderItems as total_sold' => function ($query) use ($startDate, $endDate) {
                $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                      ->whereBetween('orders.created_at', [$startDate, $endDate]);
            }])
            ->withSum(['orderItems as total_revenue' => function ($query) use ($startDate, $endDate) {
                $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                      ->selectRaw('SUM(order_items.quantity * order_items.price)')
                      ->whereBetween('orders.created_at', [$startDate, $endDate]);
            }], 'quantity')
            ->with('category')
            ->orderBy('total_sold', 'desc')
            ->paginate(20);
        
        return view('admin.reports.products', compact('products', 'startDate', 'endDate'));
    }
}
