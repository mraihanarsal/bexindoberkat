<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    protected $fillable = [
        'toko_id',
        'tanggal',
        'bulan',
        'tahun',
        'jumlah_pendapatan',
        'keterangan',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
