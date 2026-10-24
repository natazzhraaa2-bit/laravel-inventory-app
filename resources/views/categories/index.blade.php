@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kategori Produk</h1>
        <p class="text-sm text-gray-500 mt-1">Relasi One-to-Many: <code>Category hasMany Product</code>.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 w-16 text-center">No</th>
                    <th class="px-6 py-3">Nama Kategori</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3 text-center">Jumlah Produk</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $idx => $cat)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 text-center font-semibold text-gray-400">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $cat->name }}</td>
                        <td class="px-6 py-4 text-gray-500 max-w-sm truncate">{{ $cat->description ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                {{ $cat->products_count }} Produk
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('categories.edit', $cat) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-xs bg-indigo-50 px-2.5 py-1.5 rounded transition">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                            </a>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
