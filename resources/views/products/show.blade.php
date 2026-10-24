@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $product->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Detail Resource: <code>ProductController@show</code> &bull; SKU: <strong class="font-mono text-indigo-700">{{ $product->sku }}</strong></p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.edit', $product) }}" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">
                <i class="fa-solid fa-pen mr-1"></i> Edit
            </a>
            <a href="{{ route('products.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-gray-200">
            <p class="text-xs text-gray-500 font-semibold uppercase">Kategori</p>
            <p class="text-base font-bold text-gray-800 mt-1">{{ $product->category->name }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200">
            <p class="text-xs text-gray-500 font-semibold uppercase">Harga Satuan</p>
            <p class="text-base font-bold text-indigo-700 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200">
            <p class="text-xs text-gray-500 font-semibold uppercase">Stok Tersedia</p>
            <p class="text-base font-bold {{ $product->isLowStock() ? 'text-rose-600' : 'text-emerald-600' }} mt-1">
                {{ $product->stock }} Unit (Min: {{ $product->minimum_stock }})
            </p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200">
            <p class="text-xs text-gray-500 font-semibold uppercase">Total Valuasi</p>
            <p class="text-base font-bold text-gray-800 mt-1">Rp {{ number_format($product->stock * $product->price, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Mitra Supplier (Many-to-Many via Eloquent) -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="px-5 py-3.5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-800 flex items-center">
                <i class="fa-solid fa-truck-field text-indigo-600 mr-2"></i> Mitra Supplier Terhubung (Many-to-Many)
            </h2>
            <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded font-semibold">
                {{ $product->suppliers->count() }} Mitra
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3">Nama Supplier</th>
                        <th class="px-5 py-3">Kontak Person</th>
                        <th class="px-5 py-3">Telepon / Email</th>
                        <th class="px-5 py-3 text-right">Harga Pasokan (Pivot)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($product->suppliers as $sup)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-5 py-3.5 font-semibold text-gray-800">{{ $sup->name }}</td>
                            <td class="px-5 py-3.5">{{ $sup->contact_person ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-xs text-gray-500">
                                <div>{{ $sup->phone ?? '-' }}</div>
                                <div>{{ $sup->email ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-bold text-indigo-700">
                                {{ $sup->pivot->supplier_price ? 'Rp ' . number_format($sup->pivot->supplier_price, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-6 text-center text-gray-400">Belum ada supplier yang dihubungkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Transaksi Mutasi Produk Ini -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="px-5 py-3.5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-800 flex items-center">
                <i class="fa-solid fa-clock-rotate-left text-indigo-600 mr-2"></i> Riwayat Mutasi Stok Produk
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('stock.in', ['product_id' => $product->id]) }}" class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded font-semibold hover:bg-emerald-100">+ Barang Masuk</a>
                <a href="{{ route('stock.out', ['product_id' => $product->id]) }}" class="text-xs bg-rose-50 text-rose-700 px-2.5 py-1 rounded font-semibold hover:bg-rose-100">- Barang Keluar</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3">Waktu</th>
                        <th class="px-5 py-3">Tipe</th>
                        <th class="px-5 py-3 text-right">Kuantitas</th>
                        <th class="px-5 py-3">Petugas</th>
                        <th class="px-5 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($product->stockMovements as $sm)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-5 py-3 text-xs text-gray-500 whitespace-nowrap">{{ $sm->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-xs font-bold {{ $sm->type === 'IN' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $sm->type }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right font-bold {{ $sm->type === 'IN' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $sm->type === 'IN' ? '+' : '-' }}{{ $sm->quantity }}
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-700">{{ $sm->user->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-xs text-gray-500">{{ $sm->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-6 text-center text-gray-400">Belum ada histori mutasi untuk produk ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
