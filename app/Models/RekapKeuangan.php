<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapKeuangan extends Model
{
    protected $fillable = [
        'bulan',
        'tahun',
        'total_pemasukan',
        'total_pengeluaran',
        'laba_bersih',
    ];
}
