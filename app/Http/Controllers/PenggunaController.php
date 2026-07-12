<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    private function checkOwner()
    {
        if (!auth()->check() || auth()->user()->role != 1) {
            abort(403, 'Akses Ditolak: Hanya Owner yang dapat mengelola pengguna.');
        }
    }

    public function index()
    {
        $this->checkOwner();
        
        $penggunas = User::orderBy('id', 'desc')->get();
        return view('dashboard.pengguna', compact('penggunas'));
    }

    public function store(Request $request)
    {
        $this->checkOwner();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|integer|in:1,2',
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $this->checkOwner();

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|integer|in:1,2',
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        // Prevent owner from accidentally demoting themselves
        if (auth()->id() === $user->id && $request->role != 1) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri menjadi Admin.');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['plain_password'] = $request->password;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->checkOwner();

        $user = User::findOrFail($id);
        
        // Prevent deleting oneself
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}