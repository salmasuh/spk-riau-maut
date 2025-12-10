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
        'tanggal_input',
    ];

    // jika ingin, format tanggal otomatis bisa via accessor (opsional)
    protected $dates = [
        'tanggal_input',
    ];
}