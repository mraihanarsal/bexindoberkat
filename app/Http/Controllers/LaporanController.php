<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapKeuangan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $rekaps = RekapKeuangan::where('tahun', $year)->orderBy('bulan')->get();
        
        $labels = [];
        $pemasukan = [];
        $pengeluaran = [];
        $labaBersih = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 10));
            $labels[] = $monthName;
            
            $rekap = $rekaps->firstWhere('bulan', $i);
            
            $pemasukan[] = $rekap ? $rekap->total_pemasukan : 0;
            $pengeluaran[] = $rekap ? $rekap->total_pengeluaran : 0;
            $labaBersih[] = $rekap ? $rekap->laba_bersih : 0;
        }

        $availableYears = RekapKeuangan::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun')->toArray();
        if (empty($availableYears)) $availableYears = [date('Y')];
        if (!in_array(date('Y'), $availableYears)) {
            $availableYears[] = (int)date('Y');
            rsort($availableYears);
        }

        $totalPemasukan = array_sum($pemasukan);
        $totalPengeluaran = array_sum($pengeluaran);
        $totalLaba = array_sum($labaBersih);

        return view('laporan.index', compact(
            'year', 'labels', 'pemasukan', 'pengeluaran', 'labaBersih', 'availableYears',
            'totalPemasukan', 'totalPengeluaran', 'totalLaba'
        ));
    }
}