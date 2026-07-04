<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Platform;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::orderBy('id', 'asc')->get();
        return view('dashboard.platform', compact('platforms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_platform' => 'required|string|max:255|unique:platforms',
        ], [
            'nama_platform.required' => 'Nama platform wajib diisi.',
            'nama_platform.unique' => 'Nama platform sudah ada.'
        ]);

        Platform::create([
            'nama_platform' => $request->nama_platform,
            'aktif' => 1,
        ]);

        return redirect()->back()->with('success', 'Platform berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $platform = Platform::findOrFail($id);

        $request->validate([
            'nama_platform' => 'required|string|max:255|unique:platforms,nama_platform,'.$id,
        ], [
            'nama_platform.required' => 'Nama platform wajib diisi.',
            'nama_platform.unique' => 'Nama platform sudah ada.'
        ]);

        $platform->update([
            'nama_platform' => $request->nama_platform,
        ]);

        return redirect()->back()->with('success', 'Platform berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $platform = Platform::findOrFail($id);
        
        // Sesuai permintaan, tidak dihapus tapi flag aktif di set ke 0
        $platform->update([
            'aktif' => 0,
        ]);

        return redirect()->back()->with('success', 'Platform berhasil dinonaktifkan!');
    }
    
    public function activate($id)
    {
        $platform = Platform::findOrFail($id);
        
        $platform->update([
            'aktif' => 1,
        ]);

        return redirect()->back()->with('success', 'Platform berhasil diaktifkan kembali!');
    }
}
