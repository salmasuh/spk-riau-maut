<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama','deskripsi','bobot','tipe','status'
    ];

    // Optional: casting bobot ke float
    protected $casts = [
        'bobot' => 'float',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id')->orderBy('nilai','desc');
    }
}