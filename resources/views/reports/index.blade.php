@extends('layouts.app')

@section('title', 'Laporan & Analisis Inventory')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Laporan & Analisis Inventory</h1>
    <p class="text-sm text-gray-500 mt-1">Laporan berbasis fungsi agregat SQL (COUNT, SUM, AVG, GROUP BY) di Laravel Eloquent.</p>
</div>

<!-- Laporan 1: Agregat Kategori (Slide 14) -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-indigo-50/50">
        <div>
            <h2 class="text-base font-bold text-gray-800 flex items-center">
                <i class="fa-solid fa-chart-pie text-indigo-600 mr-2"></i> Laporan Ringkasan per Kategori (Slide 14)
            </h2>
            <p class="text-xs text-gray-500 mt-0.5">Menghitung jumlah produk, total stok fisik, rata-rata harga jual, dan total valuasi per kategori.</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3">Nama Kategori</th>
                    <th class="px-6 py-3 text-center">Jumlah SKU</th>
                    <th class="px-6 py-3 text-right">Total Stok Fisik</th>
                    <th class="px-6 py-3 text-right">Rata-rata Harga (AVG)</th>
                    <th class="px-6 py-3 text-right">Total Valuasi Aset</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    $grandTotalProducts = 0;
                    $grandTotalStock = 0;
                    $grandTotalValue = 0;
                @endphp
                @foreach ($categoryReports as $cr)
                    @php
                        $grandTotalProducts += $cr->total_products;
                        $grandTotalStock    += $cr->total_stock;
                        $grandTotalValue    += $cr->total_inventory_value;
                    @endphp
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $cr->category_name }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-700">
                                {{ $cr->total_products }} SKU
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-800">{{ number_format($cr->total_stock) }} Unit</td>
                        <td class="px-6 py-4 text-right text-gray-700">Rp {{ number_format($cr->average_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-indigo-700">Rp {{ number_format($cr->total_inventory_value, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-indigo-900 text-white font-bold text-sm">
                <tr>
                    <td class="px-6 py-3.5">TOTAL KESELURUHAN</td>
                    <td class="px-6 py-3.5 text-center">{{ $grandTotalProducts }} SKU</td>
                    <td class="px-6 py-3.5 text-right">{{ number_format($grandTotalStock) }} Unit</td>
                    <td class="px-6 py-3.5 text-right">-</td>
                    <td class="px-6 py-3.5 text-right text-emerald-300">Rp {{ number_format($grandTotalValue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Laporan 2: Mutasi Masuk/Keluar per Produk (Slide 28) -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-base font-bold text-gray-800 flex items-center">
            <i class="fa-solid fa-list-check text-indigo-600 mr-2"></i> Rekapitulasi Mutasi & Konsistensi Stok (Slide 28)
        </h2>
        <p class="text-xs text-gray-500 mt-0.5">Memvalidasi formula: <span class="font-mono font-semibold text-indigo-700">Stok Akhir = Total Masuk (IN) &minus; Total Keluar (OUT)</span></p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3">SKU</th>
                    <th class="px-6 py-3">Nama Produk</th>
                    <th class="px-6 py-3 text-right">Total Masuk (IN)</th>
                    <th class="px-6 py-3 text-right">Total Keluar (OUT)</th>
                    <th class="px-6 py-3 text-right">Stok Aktual di DB</th>
                    <th class="px-6 py-3 text-center">Status Integritas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($productReports as $pr)
                    @php 
                        $calculatedStock = $pr->total_in - $pr->total_out;
                        $isConsistent = ($calculatedStock === (int)$pr->current_stock);
                    @endphp
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-3.5 font-mono text-xs font-bold text-indigo-700 whitespace-nowrap">{{ $pr->sku }}</td>
                        <td class="px-6 py-3.5 font-medium text-gray-800">{{ $pr->name }}</td>
                        <td class="px-6 py-3.5 text-right font-bold text-emerald-600">+{{ number_format($pr->total_in) }}</td>
                        <td class="px-6 py-3.5 text-right font-bold text-rose-600">-{{ number_format($pr->total_out) }}</td>
                        <td class="px-6 py-3.5 text-right font-bold text-gray-900">{{ number_format($pr->current_stock) }}</td>
                        <td class="px-6 py-3.5 text-center whitespace-nowrap">
                            @if ($isConsistent)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-check mr-1"></i> Konsisten ({{ $calculatedStock }})
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-rose-100 text-rose-800">
                                    <i class="fa-solid fa-xmark mr-1"></i> Tidak Cocok (Kalkulasi: {{ $calculatedStock }})
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
