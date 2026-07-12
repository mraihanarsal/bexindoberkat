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
        'user_id',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
