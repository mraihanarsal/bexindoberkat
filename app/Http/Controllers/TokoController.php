<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Toko;
use App\Models\Platform;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::with('platform')->orderBy('id', 'asc')->get();
        // Ambil platform yang aktif saja untuk dropdown form
        $platforms = Platform::where('aktif', 1)->orderBy('nama_platform', 'asc')->get();
        return view('dashboard.toko', compact('tokos', 'platforms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'nama_toko' => 'required|string|max:255',
        ], [
            'platform_id.required' => 'Platform wajib dipilih.',
            'platform_id.exists' => 'Platform tidak valid.',
            'nama_toko.required' => 'Nama toko wajib diisi.',
        ]);

        Toko::create([
            'platform_id' => $request->platform_id,
            'nama_toko' => $request->nama_toko,
            'aktif' => 1,
        ]);

        return redirect()->back()->with('success', 'Toko berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);

        $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'nama_toko' => 'required|string|max:255',
        ], [
            'platform_id.required' => 'Platform wajib dipilih.',
            'platform_id.exists' => 'Platform tidak valid.',
            'nama_toko.required' => 'Nama toko wajib diisi.',
        ]);

        $toko->update([
            'platform_id' => $request->platform_id,
            'nama_toko' => $request->nama_toko,
        ]);

        return redirect()->back()->with('success', 'Toko berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);
        
        $toko->update([
            'aktif' => 0,
        ]);

        return redirect()->back()->with('success', 'Toko berhasil dinonaktifkan!');
    }
    
    public function activate($id)
    {
        $toko = Toko::findOrFail($id);
        
        $toko->update([
            'aktif' => 1,
        ]);

        return redirect()->back()->with('success', 'Toko berhasil diaktifkan kembali!');
    }
}
