@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Data Produk</h1>
            <p class="text-sm text-gray-500 mt-1">Resource Controller: <code>ProductController@update</code> (HTTP PUT)</p>
        </div>
        <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
            &larr; Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded mb-6 text-sm">
            <p class="font-bold mb-1">Terjadi kesalahan validasi:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-semibold text-gray-700 mb-1">Kode SKU <span class="text-rose-500">*</span></label>
                    <input type="text" name="sku" id="sku" required value="{{ old('sku', $product->sku) }}"
                        class="w-full px-4 py-2 border @error('sku') border-rose-500 @else border-gray-300 @enderror rounded-lg uppercase font-mono text-sm focus:ring-2 focus:ring-indigo-500">
                    @error('sku')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="sm:col-span-2">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2 border @error('category_id') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name', $product->name) }}"
                    class="w-full px-4 py-2 border @error('name') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Harga, Stok Saat Ini (Readonly), Minimum Stok -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" step="100" min="0" name="price" id="price" required value="{{ old('price', $product->price) }}"
                        class="w-full px-4 py-2 border @error('price') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Stok Saat Ini</label>
                    <div class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm font-bold text-gray-700 flex items-center justify-between">
                        <span>{{ $product->stock }} Unit</span>
                        <a href="{{ route('stock.in', ['product_id' => $product->id]) }}" class="text-xs text-indigo-600 hover:underline">Mutasi &rarr;</a>
                    </div>
                </div>

                <div>
                    <label for="minimum_stock" class="block text-sm font-semibold text-gray-700 mb-1">Batas Minimum Stok <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" name="minimum_stock" id="minimum_stock" required value="{{ old('minimum_stock', $product->minimum_stock) }}"
                        class="w-full px-4 py-2 border @error('minimum_stock') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Hubungkan Mitra Supplier -->
            <div class="pt-4 border-t border-gray-100">
                <label class="block text-sm font-bold text-gray-800 mb-1">
                    <i class="fa-solid fa-truck-field mr-1 text-indigo-600"></i> Hubungan Mitra Supplier (Many-to-Many)
                </label>
                <div class="space-y-2 max-h-48 overflow-y-auto p-3 border border-gray-200 rounded-lg bg-gray-50/50">
                    @php
                        $attachedSupplierIds = $product->suppliers->pluck('id')->toArray();
                        $attachedPrices = $product->suppliers->pluck('pivot.supplier_price', 'id')->toArray();
                    @endphp
                    @foreach ($suppliers as $s)
                        <div class="flex items-center justify-between p-2 rounded bg-white border border-gray-200 text-xs">
                            <label class="flex items-center space-x-2 cursor-pointer flex-1">
                                <input type="checkbox" name="suppliers[]" value="{{ $s->id }}" class="rounded text-indigo-600"
                                    {{ in_array($s->id, old('suppliers', $attachedSupplierIds)) ? 'checked' : '' }}>
                                <span class="font-medium text-gray-800">{{ $s->name }}</span>
                            </label>
                            <div class="flex items-center space-x-1">
                                <span class="text-gray-400">Harga Beli:</span>
                                <input type="number" step="100" min="0" name="supplier_prices[{{ $s->id }}]"
                                    value="{{ old("supplier_prices.{$s->id}", $attachedPrices[$s->id] ?? '') }}" placeholder="Rp 0"
                                    class="w-28 px-2 py-1 text-xs border border-gray-300 rounded">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition">
                    Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
