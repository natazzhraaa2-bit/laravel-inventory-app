@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Overview (Laravel)</h1>
            <p class="text-sm text-gray-500 mt-1">Implementasi arsitektur MVC & Eloquent ORM dari project Inventory P4.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex flex-wrap gap-2">
            <a href="{{ route('stock.in') }}" class="inline-flex items-center px-3.5 py-2 rounded-lg text-sm font-medium bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition">
                <i class="fa-solid fa-plus-circle mr-1.5"></i> Barang Masuk
            </a>
            <a href="{{ route('stock.out') }}" class="inline-flex items-center px-3.5 py-2 rounded-lg text-sm font-medium bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition">
                <i class="fa-solid fa-minus-circle mr-1.5"></i> Barang Keluar
            </a>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-3.5 py-2 rounded-lg text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm transition">
                <i class="fa-solid fa-box mr-1.5"></i> Tambah Produk
            </a>
        </div>
    </div>
</div>

<!-- 4 Grid Kartu Ringkasan -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Card 1: Total Produk -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Produk</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalProducts) }}</h3>
            <span class="text-xs text-indigo-600 font-medium">Model Product::count()</span>
        </div>
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
    </div>

    <!-- Card 2: Nilai Inventory -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Nilai Inventory</p>
            <h3 class="text-xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</h3>
            <span class="text-xs text-emerald-600 font-medium">Σ(stok × harga)</span>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
    </div>

    <!-- Card 3: Stok Rendah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok Rendah</p>
            <h3 class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-gray-800' }} mt-1">{{ number_format($lowStockCount) }}</h3>
            <span class="text-xs text-rose-500 font-medium">&le; Batas Minimum</span>
        </div>
        <div class="w-12 h-12 {{ $lowStockCount > 0 ? 'bg-rose-100 text-rose-600 animate-pulse' : 'bg-gray-100 text-gray-500' }} rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
    </div>

    <!-- Card 4: Total Mutasi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Aktivitas Mutasi</p>
            <div class="flex items-center space-x-3 mt-1">
                <span class="text-sm font-bold text-emerald-600"><i class="fa-solid fa-arrow-down text-xs"></i> {{ $totalIn }}</span>
                <span class="text-sm font-bold text-rose-600"><i class="fa-solid fa-arrow-up text-xs"></i> {{ $totalOut }}</span>
            </div>
            <span class="text-xs text-gray-400">Total IN vs OUT</span>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-right-left"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Peringatan Stok Rendah (Col 1) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-rose-50/50">
            <h2 class="font-bold text-gray-800 text-sm flex items-center">
                <i class="fa-solid fa-triangle-exclamation text-rose-500 mr-2"></i> Peringatan Stok Rendah
            </h2>
            <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="text-xs text-indigo-600 hover:underline font-medium">Lihat Semua</a>
        </div>
        <div class="p-4">
            @forelse ($lowStockProducts as $lp)
                <div class="py-3 flex items-center justify-between border-b border-gray-100 last:border-b-0">
                    <div>
                        <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $lp->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $lp->sku }} &bull; {{ $lp->category->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-rose-100 text-rose-700">
                            Sisa: {{ $lp->stock }} (Min: {{ $lp->minimum_stock }})
                        </span>
                        <div class="mt-1">
                            <a href="{{ route('stock.in', ['product_id' => $lp->id]) }}" class="text-xs text-emerald-600 hover:text-emerald-800 font-semibold">
                                + Restock
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-400 text-sm">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-3xl mb-2 block"></i>
                    Semua stok produk dalam batas aman.
                </div>
            @endforelse
        </div>
    </div>

    <!-- 5 Mutasi Terakhir (Col 2-3) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden lg:col-span-2">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-800 text-sm flex items-center">
                <i class="fa-solid fa-clock-rotate-left text-indigo-500 mr-2"></i> Mutasi Transaksi Terakhir
            </h2>
            <a href="{{ route('stock.history') }}" class="text-xs text-indigo-600 hover:underline font-medium">Lihat Riwayat Lengkap</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                        <th class="px-4 py-3">Petugas</th>
                        <th class="px-4 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recentMovements as $rm)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">{{ $rm->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $rm->product->name }}
                                <span class="block text-xs text-gray-400">{{ $rm->product->sku }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($rm->type === 'IN')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-arrow-down mr-1"></i> MASUK
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-rose-100 text-rose-800">
                                        <i class="fa-solid fa-arrow-up mr-1"></i> KELUAR
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right font-bold {{ $rm->type === 'IN' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $rm->type === 'IN' ? '+' : '-' }}{{ $rm->quantity }}
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-700 whitespace-nowrap">{{ $rm->user->name }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500 truncate max-w-xs">{{ $rm->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada riwayat mutasi stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
