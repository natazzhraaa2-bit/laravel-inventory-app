@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Pengguna Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Resource Controller: <code>UserController@store</code></p>
        </div>
        <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
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
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username Login <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" id="username" required value="{{ old('username') }}"
                        class="w-full px-4 py-2 border @error('username') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: staff_andi">
                    @error('username')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border @error('password') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Minimal 6 karakter">
                    @error('password')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                    class="w-full px-4 py-2 border @error('name') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                    placeholder="Contoh: Andi Pratama">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border @error('email') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="andi@inventory.local">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: 08129876543">
                </div>
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Role / Hak Akses <span class="text-rose-500">*</span></label>
                <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff (Hanya operasional katalog & transaksi)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Akses penuh termasuk manajemen user)</option>
                </select>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition">
                    Daftarkan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
