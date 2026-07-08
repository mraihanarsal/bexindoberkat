<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'nama_pengeluaran',
        'tanggal',
        'bulan',
        'tahun',
        'jumlah_pengeluaran',
        'keterangan',
    ];
}
