<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $fillable = [
        'platform_id',
        'nama_toko',
        'aktif',
    ];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function pemasukans()
    {
        return $this->hasMany(Pemasukan::class);
    }
}
