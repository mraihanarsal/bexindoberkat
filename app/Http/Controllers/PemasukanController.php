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

    public function grafik(Request $request)
    {
        $period1 = $request->input('period1');
        if (!$period1 || !preg_match('/^\d{4}-\d{2}$/', $period1)) $period1 = date('Y-m');
        
        $period2 = $request->input('period2');
        if (!$period2 || !preg_match('/^\d{4}-\d{2}$/', $period2)) $period2 = date('Y-m', strtotime('-1 month'));
        
        $p1 = explode('-', $period1);
        $year1 = (int)$p1[0];
        $month1 = (int)$p1[1];
        
        $p2 = explode('-', $period2);
        $year2 = (int)$p2[0];
        $month2 = (int)$p2[1];

        $data1 = Pemasukan::with('toko')->where('bulan', $month1)->where('tahun', $year1)->get();
        $data2 = Pemasukan::with('toko')->where('bulan', $month2)->where('tahun', $year2)->get();

        $total1 = $data1->sum('jumlah_pendapatan');
        $total2 = $data2->sum('jumlah_pendapatan');

        $tokoData1 = [];
        foreach($data1 as $item) {
            if(!isset($tokoData1[$item->toko->nama_toko])) $tokoData1[$item->toko->nama_toko] = 0;
            $tokoData1[$item->toko->nama_toko] += $item->jumlah_pendapatan;
        }
        $tokoData2 = [];
        foreach($data2 as $item) {
            if(!isset($tokoData2[$item->toko->nama_toko])) $tokoData2[$item->toko->nama_toko] = 0;
            $tokoData2[$item->toko->nama_toko] += $item->jumlah_pendapatan;
        }

        $labels = array_unique(array_merge(array_keys($tokoData1), array_keys($tokoData2)));
        sort($labels);
        
        $chartToko1 = [];
        $chartToko2 = [];
        foreach($labels as $label) {
            $chartToko1[] = $tokoData1[$label] ?? 0;
            $chartToko2[] = $tokoData2[$label] ?? 0;
        }

        $availableYears = Pemasukan::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun')->toArray();
        if(empty($availableYears)) $availableYears = [date('Y')];
        if(!in_array(date('Y'), $availableYears)) {
            $availableYears[] = date('Y');
            rsort($availableYears);
        }

        return view('pemasukan.grafik', compact(
            'period1', 'period2',
            'month1', 'year1', 'month2', 'year2',
            'total1', 'total2',
            'labels', 'chartToko1', 'chartToko2',
            'availableYears'
        ));
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