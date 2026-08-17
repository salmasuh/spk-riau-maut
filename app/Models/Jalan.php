<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jalan',
        'kabupaten_kota',
        'status',
        'panjang',
    ];

    public function volume_lhr()
    {
        return $this->hasOne(VolumeLhr::class);
    }
}