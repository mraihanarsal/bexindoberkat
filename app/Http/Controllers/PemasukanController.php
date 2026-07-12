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
        $data['user_id'] = auth()->id();

        Pemasukan::create($data);

        $this->syncRekap($data['bulan'], $data['tahun']);

        return redirect()->route('pemasukan.riwayat')->with('success', 'Data pemasukan berhasil disimpan!');
    }

    public function uploadPdf(Request $request)
    {
        $request->validate([
            'pdfs' => 'required|array',
            'pdfs.*' => 'required|mimes:pdf|max:10240', // max 10MB
        ]);

        $tokos = Toko::all();
        $parser = new \Smalot\PdfParser\Parser();
        $successCount = 0;
        $errors = [];

        foreach ($request->file('pdfs') as $file) {
            try {
                $pdf = $parser->parseFile($file->getPathname());
                $text = $pdf->getText();
                $text = preg_replace('/\s+/', ' ', $text); // Normalize whitespace

                // 1. Extract Amount
                $amount = 0;
                // Look for "Total Penghasilan Rp361,298,727"
                if (preg_match('/Total Penghasilan.*?Rp\s*([0-9,\.]+)/i', $text, $matches)) {
                    $amountStr = str_replace([',', '.'], '', $matches[1]);
                    $amount = (float)$amountStr;
                } else if (preg_match('/Total\s+Rp\s*([0-9,\.]+)/i', $text, $matches)) {
                    $amountStr = str_replace([',', '.'], '', $matches[1]);
                    $amount = (float)$amountStr;
                }

                if ($amount <= 0) {
                    $errors[] = "File " . $file->getClientOriginalName() . ": Gagal menemukan Total Penghasilan.";
                    continue;
                }

                // 2. Extract Toko
                $matchedTokoId = null;
                foreach ($tokos as $toko) {
                    if (stripos($text, $toko->nama_toko) !== false) {
                        $matchedTokoId = $toko->id;
                        break;
                    }
                }

                if (!$matchedTokoId) {
                    $errors[] = "File " . $file->getClientOriginalName() . ": Gagal mencocokkan Nama Toko.";
                    continue;
                }

                // 3. Extract Date (try to find period end date like "sampai 2025-06-30")
                $tanggal = date('Y-m-d');
                $bulan = (int)date('n');
                $tahun = (int)date('Y');

                if (preg_match('/sampai\s+(\d{4}-\d{2}-\d{2})/i', $text, $dateMatches)) {
                    $tanggal = $dateMatches[1];
                    $parsedDate = strtotime($tanggal);
                    $bulan = (int)date('n', $parsedDate);
                    $tahun = (int)date('Y', $parsedDate);
                }

                Pemasukan::create([
                    'toko_id' => $matchedTokoId,
                    'tanggal' => $tanggal,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jumlah_pendapatan' => $amount,
                    'keterangan' => 'Auto-import dari PDF: ' . $file->getClientOriginalName(),
                    'user_id' => auth()->id(),
                ]);

                $this->syncRekap($bulan, $tahun);
                $successCount++;

            } catch (\Exception $e) {
                $errors[] = "File " . $file->getClientOriginalName() . ": " . $e->getMessage();
            }
        }

        $msg = "$successCount data pemasukan berhasil diimport.";
        if (count($errors) > 0) {
            return redirect()->route('pemasukan.riwayat')->with('success', $msg)->withErrors($errors);
        }

        return redirect()->route('pemasukan.riwayat')->with('success', $msg);
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