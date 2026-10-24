<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Laporan Agregasi Kategori (Slide 14)
        $categoryReports = Category::query()
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('COUNT(products.id) as total_products'),
                DB::raw('COALESCE(SUM(products.stock), 0) as total_stock'),
                DB::raw('COALESCE(AVG(products.price), 0) as average_price'),
                DB::raw('COALESCE(SUM(products.stock * products.price), 0) as total_inventory_value')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_inventory_value', 'desc')
            ->get();

        // 2. Laporan Rekapitulasi Mutasi Stok per Produk (Slide 28)
        $productReports = Product::query()
            ->leftJoin('stock_movements', 'stock_movements.product_id', '=', 'products.id')
            ->select(
                'products.sku',
                'products.name',
                'products.stock as current_stock',
                DB::raw("COALESCE(SUM(CASE WHEN stock_movements.type = 'IN' THEN stock_movements.quantity ELSE 0 END), 0) as total_in"),
                DB::raw("COALESCE(SUM(CASE WHEN stock_movements.type = 'OUT' THEN stock_movements.quantity ELSE 0 END), 0) as total_out")
            )
            ->groupBy('products.id', 'products.sku', 'products.name', 'products.stock')
            ->orderBy('products.name', 'asc')
            ->get();

        return view('reports.index', compact('categoryReports', 'productReports'));
    }
}
