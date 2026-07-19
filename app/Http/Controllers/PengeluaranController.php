<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Models\Pengeluaran;
use App\Models\Kategori;
use App\Models\RekapKeuangan;

class PengeluaranController extends Controller 
{ 
    public function input() 
    { 
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('pengeluaran.input', compact('kategoris')); 
    } 

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'hari' => 'required|integer|min:1|max:31',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'jumlah_pengeluaran' => 'required|numeric|min:0|max:999999999999999',
            'keterangan' => 'nullable|string'
        ]);

        if (!checkdate($request->bulan, $request->hari, $request->tahun)) {
            return back()->withErrors(['hari' => 'Kombinasi Tanggal, Bulan, dan Tahun tidak valid.'])->withInput();
        }

        $data = $request->all();
        $data['tanggal'] = $request->tahun . '-' . str_pad($request->bulan, 2, '0', STR_PAD_LEFT) . '-' . str_pad($request->hari, 2, '0', STR_PAD_LEFT);
        $data['bulan'] = (int)$request->bulan;
        $data['tahun'] = (int)$request->tahun;

        Pengeluaran::create($data);

        $this->syncRekap($data['bulan'], $data['tahun']);

        return redirect()->route('pengeluaran.riwayat')->with('success', 'Data pengeluaran berhasil disimpan!');
    }

    public function riwayat() 
    { 
        $pengeluarans = Pengeluaran::latest('tanggal')->latest('id')->paginate(10);
        return view('pengeluaran.riwayat', compact('pengeluarans')); 
    } 

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $bulan = $pengeluaran->bulan;
        $tahun = $pengeluaran->tahun;
        $pengeluaran->delete();
        
        $this->syncRekap($bulan, $tahun);
        
        return redirect()->route('pengeluaran.riwayat')->with('success', 'Data pengeluaran berhasil dihapus!');
    }

    private function syncRekap($bulan, $tahun)
    {
        $totalPemasukan = \App\Models\Pemasukan::where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah_pendapatan');
        $totalPengeluaran = Pengeluaran::where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah_pengeluaran');

        RekapKeuangan::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun],
            [
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $totalPemasukan - $totalPengeluaran
            ]
        );
    }
}