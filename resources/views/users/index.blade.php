@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <div class="flex items-center space-x-2">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen Pengguna</h1>
            <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2 py-0.5 rounded border border-purple-200">
                <i class="fa-solid fa-lock mr-1"></i> Khusus Admin
            </span>
        </div>
        <p class="text-sm text-gray-500 mt-1">Mengelola akun login dan hak akses pengguna sistem (Slide 24).</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i class="fa-solid fa-user-plus mr-2"></i> Tambah Pengguna Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 w-16 text-center">ID</th>
                    <th class="px-6 py-3">Username & Role</th>
                    <th class="px-6 py-3">Nama Lengkap</th>
                    <th class="px-6 py-3">Email & Telepon</th>
                    <th class="px-6 py-3">Terdaftar Sejak</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($users as $u)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 text-center font-bold text-gray-400">{{ $u->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-800">{{ $u->username }}</div>
                            <span class="inline-block mt-0.5 px-2 py-0.2 rounded text-[11px] font-bold {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ strtoupper($u->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $u->name }}</td>
                        <td class="px-6 py-4 text-gray-500 text-xs">
                            <div>{{ $u->email ?? '-' }}</div>
                            <div>{{ $u->phone ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                            {{ $u->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            @if ($u->id === Auth::id())
                                <span class="text-xs text-gray-400 italic">Akun Anda saat ini</span>
                            @else
                                <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs bg-rose-50 px-2.5 py-1.5 rounded font-medium transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
