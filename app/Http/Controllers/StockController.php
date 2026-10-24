<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    public function createIn(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $selectedProductId = $request->query('product_id');

        return view('stock.in', compact('products', 'selectedProductId'));
    }

    public function storeIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'notes'      => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);
            $product->increment('stock', $validated['quantity']);

            StockMovement::create([
                'product_id' => $product->id,
                'user_id'    => Auth::id() ?? 1,
                'type'       => 'IN',
                'quantity'   => $validated['quantity'],
                'notes'      => $validated['notes'] ?: 'Penerimaan barang masuk',
            ]);
        });

        return redirect()->route('stock.history')
            ->with('success', "Berhasil menambahkan {$validated['quantity']} unit barang masuk.");
    }

    public function createOut(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $selectedProductId = $request->query('product_id');

        return view('stock.out', compact('products', 'selectedProductId'));
    }

    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'notes'      => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            // Business Rule: Barang keluar tidak boleh melebihi stok tersedia (Slide 26, 33)
            if ($validated['quantity'] > $product->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "Jumlah barang keluar ({$validated['quantity']}) melebihi stok tersedia ({$product->stock} unit). Transaksi ditolak agar stok tidak menjadi negatif."
                ]);
            }

            $product->decrement('stock', $validated['quantity']);

            StockMovement::create([
                'product_id' => $product->id,
                'user_id'    => Auth::id() ?? 1,
                'type'       => 'OUT',
                'quantity'   => $validated['quantity'],
                'notes'      => $validated['notes'] ?: 'Pengeluaran barang / penjualan',
            ]);
        });

        return redirect()->route('stock.history')
            ->with('success', "Berhasil mencatat pengeluaran {$validated['quantity']} unit barang.");
    }

    public function history(Request $request)
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->product_id, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $products = Product::orderBy('name')->get();

        return view('stock.history', compact('movements', 'products'));
    }
}
