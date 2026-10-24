@extends('layouts.app')

@section('title', 'Pengeluaran Barang Keluar (OUT)')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center">
                <span class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center mr-2 text-base">
                    <i class="fa-solid fa-arrow-up"></i>
                </span>
                Pengeluaran Barang Keluar (OUT)
            </h1>
            <p class="text-sm text-gray-500 mt-1">Validasi stok tersedia dan DB Transaction di <code>StockController@storeOut</code>.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
            &larr; Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded mb-6 text-sm">
            <p class="font-bold mb-1">Gagal memproses pengeluaran barang:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('stock.out.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Pilih Produk -->
            <div>
                <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Produk <span class="text-rose-500">*</span></label>
                <select name="product_id" id="product_id" required class="w-full px-4 py-2.5 border @error('product_id') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih Produk yang Dikeluarkan --</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" {{ old('product_id', $selectedProductId) == $p->id ? 'selected' : '' }}>
                            [{{ $p->sku }}] {{ $p->name }} &mdash; Tersedia: {{ $p->stock }} Unit
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jumlah Keluar -->
            <div>
                <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Keluar (Unit) <span class="text-rose-500">*</span></label>
                <input type="number" min="1" name="quantity" id="quantity" required value="{{ old('quantity') }}"
                    class="w-full px-4 py-2 border @error('quantity') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-rose-500"
                    placeholder="Contoh: 3">
                <span class="text-xs text-rose-600 font-medium">Aturan: Jumlah tidak boleh melebihi stok yang ada.</span>
            </div>

            <!-- Keterangan Transaksi -->
            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Keterangan / Alasan Pengeluaran</label>
                <textarea name="notes" id="notes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500"
                    placeholder="Contoh: Penjualan pesanan invoice">{{ old('notes') }}</textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold shadow-sm transition flex items-center">
                    <i class="fa-solid fa-arrow-up mr-2"></i> Konfirmasi Barang Keluar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
