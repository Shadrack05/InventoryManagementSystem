<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Branch;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStatistics extends Controller
{
    public function statistics(Request $request)
    {
        $today = Carbon::today();

        $totalSalesToday = Sale::whereDate('created_at', $today)->sum('sold_at');

        $topProduct = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sales.quantity) as total_quantity'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->first();

        // Get least sold product
        $leastProduct = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sales.quantity) as total_quantity'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity')
            ->first();

    // Get total transfers today
    $totalTransfers = Transfer::whereDate('created_at', $today)->count();

    return response()->json([
        'totalSalesToday' => $totalSalesToday,
        'topProduct' => $topProduct ? $topProduct->name : 'No sales yet',
        'leastProduct' => $leastProduct ? $leastProduct->name : 'No sales yet',
        'totalTransfers' => $totalTransfers
    ]);

    }

    public function branchStatistics(Request $request, $branchId = null)
    {
        $today = Carbon::today();

        // Get stores for the branch
        $storeIds = DB::table('stores')
            ->where('branch_id', $branchId)
            ->pluck('id');

        // Total sales today for the branch
        $totalSalesToday = Sale::whereIn('store_id', $storeIds)
            ->whereDate('created_at', $today)
            ->sum('sold_at');

        // Top selling product in the branch
        $topProduct = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->whereIn('sales.store_id', $storeIds)
            ->select(
                'products.name',
                DB::raw('SUM(sales.quantity) as total_quantity'),
                DB::raw('SUM(sales.sold_at) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->first();

        // Least selling product in the branch
        $leastProduct = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->whereIn('sales.store_id', $storeIds)
            ->select(
                'products.name',
                DB::raw('SUM(sales.quantity) as total_quantity'),
                DB::raw('SUM(sales.sold_at) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity')
            ->first();

        // Total transfers for the branch today
        $totalTransfers = Transfer::whereIn('from_store_id', $storeIds)
            ->orWhereIn('to_store_id', $storeIds)
            ->whereDate('created_at', $today)
            ->count();

        // Get all branches with their statistics
        $branchesStats = Branch::with('stores')
            ->select('branches.*')
            ->selectRaw('
                (SELECT SUM(s.sold_at)
                FROM sales s
                JOIN stores st ON s.store_id = st.id
                WHERE st.branch_id = branches.id
                AND DATE(s.created_at) = ?) as total_sales
            ', [$today])
            ->selectRaw('
                (SELECT COUNT(*)
                FROM transfers t
                JOIN stores st ON t.from_store_id = st.id OR t.to_store_id = st.id
                WHERE st.branch_id = branches.id
                AND DATE(t.created_at) = ?) as total_transfers
            ', [$today])
            ->get();

        return response()->json([
            'branchId' => $branchId,
            'totalSalesToday' => $totalSalesToday,
            'topProduct' => $topProduct ? [
                'name' => $topProduct->name,
                'quantity' => $topProduct->total_quantity,
                'sales' => $topProduct->total_sales
            ] : 'No sales yet',
            'leastProduct' => $leastProduct ? [
                'name' => $leastProduct->name,
                'quantity' => $leastProduct->total_quantity,
                'sales' => $leastProduct->total_sales
            ] : 'No sales yet',
            'totalTransfers' => $totalTransfers,
            'allBranches' => $branchesStats->map(function($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'total_sales' => $branch->total_sales ?? 0,
                    'total_transfers' => $branch->total_transfers ?? 0,
                    'stores_count' => $branch->stores->count()
                ];
            })
        ]);
    }

    public function storeStatistics(Request $request, $storeId)
    {
        $today = Carbon::today();

        // Get store details with its branch
        $store = DB::table('stores')
            ->join('branches', 'stores.branch_id', '=', 'branches.id')
            ->where('stores.id', $storeId)
            ->select('stores.*', 'branches.name as branch_name')
            ->first();

        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }

        // Total sales today for the store
        $totalSalesToday = Sale::where('store_id', $storeId)
            ->whereDate('created_at', $today)
            ->sum('sold_at');

        // Top selling product in the store
        $topProduct = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->where('sales.store_id', $storeId)
            ->select(
                'products.name',
                'products.id',
                DB::raw('SUM(sales.quantity) as total_quantity'),
                DB::raw('SUM(sales.sold_at) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->first();

        // Least selling product in the store
        $leastProduct = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->where('sales.store_id', $storeId)
            ->select(
                'products.name',
                'products.id',
                DB::raw('SUM(sales.quantity) as total_quantity'),
                DB::raw('SUM(sales.sold_at) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity')
            ->first();

        // Total transfers for the store today
        $totalTransfers = Transfer::where(function($query) use ($storeId) {
                $query->where('from_store_id', $storeId)
                      ->orWhere('to_store_id', $storeId);
            })
            ->whereDate('created_at', $today)
            ->count();

        // Get current stock levels
        $currentStock = DB::table('stocks')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->where('store_id', $storeId)
            ->select(
                'products.name',
                'stocks.quantity',
                'stocks.price'
            )
            ->get();

        // Calculate store performance metrics
        $weeklyStats = Sale::where('store_id', $storeId)
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(sold_at) as daily_sales'),
                DB::raw('COUNT(*) as transactions_count')
            )
            ->groupBy('date')
            ->get();

        return response()->json([
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
                'branch' => $store->branch_name
            ],
            'today' => [
                'totalSales' => $totalSalesToday,
                'totalTransfers' => $totalTransfers,
                'topProduct' => $topProduct ? [
                    'name' => $topProduct->name,
                    'quantity' => $topProduct->total_quantity,
                    'sales' => $topProduct->total_sales
                ] : 'No sales yet',
                'leastProduct' => $leastProduct ? [
                    'name' => $leastProduct->name,
                    'quantity' => $leastProduct->total_quantity,
                    'sales' => $leastProduct->total_sales
                ] : 'No sales yet'
            ],
            'inventory' => [
                'currentStock' => $currentStock,
                'totalProducts' => $currentStock->count(),
                'totalValue' => $currentStock->sum(function($item) {
                    return $item->quantity * $item->price;
                })
            ],
            'performance' => [
                'weekly' => $weeklyStats,
                'averageDailySales' => $weeklyStats->avg('daily_sales') ?? 0,
                'averageTransactions' => $weeklyStats->avg('transactions_count') ?? 0
            ]
        ]);
    }
}
