<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = ['jalan_id', 'penilai', 'nilai_kriteria', 'status'];

    protected $casts = [
        'nilai_kriteria' => 'array',
    ];

    public function jalan()
    {
        return $this->belongsTo(Jalan::class);
    }
    
}