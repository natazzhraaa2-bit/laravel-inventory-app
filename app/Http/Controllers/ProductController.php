<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $allowedSort = [
            'name'  => 'name',
            'sku'   => 'sku',
            'price' => 'price',
            'stock' => 'stock',
            'date'  => 'created_at',
        ];
        $sortKey = $request->query('sort', 'name');
        $sortCol = $allowedSort[$sortKey] ?? 'name';
        $direction = strtolower($request->query('direction', 'asc')) === 'desc' ? 'desc' : 'asc';

        $products = Product::with(['category', 'suppliers'])
            ->withCount('stockMovements')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->boolean('low_stock'), function ($query) {
                $query->whereColumn('stock', '<=', 'minimum_stock');
            })
            ->orderBy($sortCol, $direction)
            ->paginate(5)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'sku'           => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name'          => ['required', 'string', 'max:150'],
            'price'         => ['required', 'numeric', 'min:0'],
            'stock'         => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'suppliers'     => ['nullable', 'array'],
            'suppliers.*'   => ['exists:suppliers,id'],
            'supplier_prices' => ['nullable', 'array'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::create([
                'category_id'   => $validated['category_id'],
                'sku'           => strtoupper($validated['sku']),
                'name'          => $validated['name'],
                'price'         => $validated['price'],
                'stock'         => $validated['stock'],
                'minimum_stock' => $validated['minimum_stock'],
            ]);

            // Jika ada stok awal > 0, catat histori mutasi barang masuk (Slide 25)
            if ($validated['stock'] > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id'    => Auth::id() ?? 1,
                    'type'       => 'IN',
                    'quantity'   => $validated['stock'],
                    'notes'      => 'Stok awal pendaftaran produk',
                ]);
            }

            // Simpan relasi Many-to-Many Supplier
            if (!empty($validated['suppliers'])) {
                $syncData = [];
                foreach ($validated['suppliers'] as $supId) {
                    $price = $request->input("supplier_prices.{$supId}");
                    $syncData[$supId] = [
                        'supplier_price' => is_numeric($price) && $price >= 0 ? $price : null
                    ];
                }
                $product->suppliers()->sync($syncData);
            }
        });

        return redirect()->route('products.index')
            ->with('success', "Produk '{$validated['name']}' berhasil ditambahkan.");
    }

    public function show(Product $product)
    {
        $product->load(['category', 'suppliers', 'stockMovements.user']);
        $allSuppliers = Supplier::orderBy('name')->get();

        return view('products.show', compact('product', 'allSuppliers'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();
        $product->load('suppliers');

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'sku'           => ['required', 'string', 'max:50', Rule::unique('products')->ignore($product->id)],
            'name'          => ['required', 'string', 'max:150'],
            'price'         => ['required', 'numeric', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'suppliers'     => ['nullable', 'array'],
            'suppliers.*'   => ['exists:suppliers,id'],
            'supplier_prices' => ['nullable', 'array'],
        ]);

        DB::transaction(function () use ($product, $validated, $request) {
            $product->update([
                'category_id'   => $validated['category_id'],
                'sku'           => strtoupper($validated['sku']),
                'name'          => $validated['name'],
                'price'         => $validated['price'],
                'minimum_stock' => $validated['minimum_stock'],
            ]);

            // Sync suppliers
            $syncData = [];
            if (!empty($validated['suppliers'])) {
                foreach ($validated['suppliers'] as $supId) {
                    $price = $request->input("supplier_prices.{$supId}");
                    $syncData[$supId] = [
                        'supplier_price' => is_numeric($price) && $price >= 0 ? $price : null
                    ];
                }
            }
            $product->suppliers()->sync($syncData);
        });

        return redirect()->route('products.index')
            ->with('success', "Produk '{$product->name}' berhasil diperbarui.");
    }

    public function destroy(Product $product)
    {
        // Business Rule: Produk yang memiliki histori mutasi tidak boleh dihapus (Slide 33)
        if ($product->stockMovements()->count() > 0) {
            return redirect()->route('products.index')
                ->with('error', "Gagal menghapus produk: '{$product->name}' memiliki histori mutasi stok. Referential integrity dijaga (RESTRICT).");
        }

        $product->suppliers()->detach();
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Produk '{$product->name}' berhasil dihapus.");
    }
}
