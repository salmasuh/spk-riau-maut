<?php

namespace App\Models;

use App\Models\Jalan;
use Illuminate\Database\Eloquent\Model;

class VolumeLhr extends Model
{
    protected $fillable = ['jalan_id','volume_lhr','keterangan'];

    public function jalan()
    {
        return $this->belongsTo(Jalan::class);
    }
}
