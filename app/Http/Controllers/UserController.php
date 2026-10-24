<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses Ditolak: Hanya Admin yang dapat mengelola data pengguna.');
        }

        $users = User::orderBy('id')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses Ditolak.');
        }

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'    => ['nullable', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', 'in:admin,staff'],
            'phone'    => ['nullable', 'string', 'max:30'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', "Pengguna '{$validated['username']}' berhasil didaftarkan.");
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses Ditolak.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->stockMovements()->count() > 0) {
            return redirect()->route('users.index')
                ->with('error', 'User tidak dapat dihapus karena tercatat dalam histori mutasi stok.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
