<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalInventoryValue = Product::select(DB::raw('COALESCE(SUM(stock * price), 0) as val'))->value('val');
        $lowStockCount = Product::whereColumn('stock', '<=', 'minimum_stock')->count();

        $totalIn = StockMovement::where('type', 'IN')->sum('quantity');
        $totalOut = StockMovement::where('type', 'OUT')->sum('quantity');

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalInventoryValue',
            'lowStockCount',
            'totalIn',
            'totalOut',
            'lowStockProducts',
            'recentMovements'
        ));
    }
}
