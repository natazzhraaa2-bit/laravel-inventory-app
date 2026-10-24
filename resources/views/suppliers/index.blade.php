@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Data Supplier</h1>
        <p class="text-sm text-gray-500 mt-1">Relasi Many-to-Many: <code>Product belongsToMany Supplier</code>.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Supplier
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 w-16 text-center">No</th>
                    <th class="px-6 py-3">Nama Perusahaan / Supplier</th>
                    <th class="px-6 py-3">Kontak & Telepon</th>
                    <th class="px-6 py-3">Email & Alamat</th>
                    <th class="px-6 py-3 text-center">Produk Disuplai</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($suppliers as $idx => $sup)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 text-center font-semibold text-gray-400">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $sup->name }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <div><i class="fa-solid fa-user-tie text-xs text-gray-400 mr-1.5"></i> {{ $sup->contact_person ?? '-' }}</div>
                            <div class="text-xs text-gray-400 mt-0.5"><i class="fa-solid fa-phone text-xs text-gray-400 mr-1.5"></i> {{ $sup->phone ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                            <div><i class="fa-solid fa-envelope text-xs text-gray-400 mr-1.5"></i> {{ $sup->email ?? '-' }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 truncate"><i class="fa-solid fa-location-dot text-xs text-gray-400 mr-1.5"></i> {{ $sup->address ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                {{ $sup->products_count }} Produk
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('suppliers.edit', $sup) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-xs bg-indigo-50 px-2.5 py-1.5 rounded transition">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                            </a>
                            <form action="{{ route('suppliers.destroy', $sup) }}" method="POST" class="inline" onsubmit="return confirm('Hapus supplier ini? Pasangan pada relasi many-to-many produk akan ikut terlepas.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-xs bg-rose-50 px-2.5 py-1.5 rounded transition">
                                    <i class="fa-solid fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data supplier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
