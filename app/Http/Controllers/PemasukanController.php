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
            'tanggal' => 'required|date',
            'jumlah_pendapatan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->all();
        $parsedDate = strtotime($request->tanggal);
        $data['bulan'] = (int)date('n', $parsedDate);
        $data['tahun'] = (int)date('Y', $parsedDate);
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

                // 2. Extract Toko dengan Normalisasi String
                $matchedTokoId = null;
                
                // Coba ekstrak spesifik Username dari teks (contoh: "Username : let.store")
                $extractedUsername = '';
                if (preg_match('/Username\s*:\s*([a-zA-Z0-9\.\_\-]+)/i', $text, $userMatches)) {
                    $extractedUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $userMatches[1]));
                }

                // Normalisasi seluruh teks PDF (hilangkan spasi, titik, koma, garis miring, dll)
                $normalizedText = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $text));

                foreach ($tokos as $toko) {
                    // Normalisasi nama toko dari database (misal: "let.store" atau "let store" menjadi "letstore")
                    $normalizedToko = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $toko->nama_toko));
                    
                    if (empty($normalizedToko)) continue;

                    // Cek 1: Apakah username hasil ekstrak sama persis dengan nama toko?
                    if ($extractedUsername !== '' && $extractedUsername === $normalizedToko) {
                        $matchedTokoId = $toko->id;
                        break;
                    }
                    
                    // Cek 2: Apakah nama toko terselip di dalam teks PDF yang sudah dinormalisasi?
                    if (strpos($normalizedText, $normalizedToko) !== false) {
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



    public function destroy(int $id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $bulan = $pemasukan->bulan;
        $tahun = $pemasukan->tahun;
        $pemasukan->delete();
        
        $this->syncRekap($bulan, $tahun);
        
        return redirect()->route('pemasukan.riwayat')->with('success', 'Data pemasukan berhasil dihapus!');
    }

    private function syncRekap(int $bulan, int $tahun)
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