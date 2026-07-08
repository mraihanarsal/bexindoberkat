<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Models\Pemasukan;
use App\Models\Toko;
use App\Models\RekapKeuangan;

class PemasukanController extends Controller 
{ 
    public function input() 
    { 
        $tokos = Toko::with('platform')->where('aktif', true)->get();
        return view('pemasukan.input', compact('tokos')); 
    } 

    public function store(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:tokos,id',
            'hari' => 'required|integer|min:1|max:31',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'jumlah_pendapatan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        if (!checkdate($request->bulan, $request->hari, $request->tahun)) {
            return back()->withErrors(['hari' => 'Kombinasi Tanggal, Bulan, dan Tahun tidak valid.'])->withInput();
        }

        $data = $request->all();
        $data['tanggal'] = $request->tahun . '-' . str_pad($request->bulan, 2, '0', STR_PAD_LEFT) . '-' . str_pad($request->hari, 2, '0', STR_PAD_LEFT);
        $data['bulan'] = (int)$request->bulan;
        $data['tahun'] = (int)$request->tahun;

        Pemasukan::create($data);

        $this->syncRekap($data['bulan'], $data['tahun']);

        return redirect()->route('pemasukan.riwayat')->with('success', 'Data pemasukan berhasil disimpan!');
    }

    public function riwayat() 
    { 
        $pemasukans = Pemasukan::with('toko.platform')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('pemasukan.riwayat', compact('pemasukans')); 
    } 

    public function destroy($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $bulan = $pemasukan->bulan;
        $tahun = $pemasukan->tahun;
        $pemasukan->delete();
        
        $this->syncRekap($bulan, $tahun);
        
        return redirect()->route('pemasukan.riwayat')->with('success', 'Data pemasukan berhasil dihapus!');
    }

    private function syncRekap($bulan, $tahun)
    {
        $totalPemasukan = Pemasukan::where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah_pendapatan');
        $totalPengeluaran = \App\Models\Pengeluaran::where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah_pengeluaran');

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