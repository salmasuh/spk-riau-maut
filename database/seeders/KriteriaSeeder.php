<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['nama'=>'Panjang Ruas Jalan','deskripsi'=>'Panjang Keseluruhan Jalan, baik mantap atau tidak mantap','bobot'=>0.15,'tipe'=>'cost','status'=>'aktif'],
            ['nama'=>'Panjang Kerusakan Jalan','deskripsi'=>'Panjang bagian jalan yang rusak','bobot'=>0.40,'tipe'=>'cost','status'=>'aktif'],
            ['nama'=>'Lebar Jalan','deskripsi'=>'Lebar jalur jalan yang dilalui','bobot'=>0.10,'tipe'=>'cost','status'=>'aktif'],
            ['nama'=>'Jenis Permukaan Jalan','deskripsi'=>'Permukaan (aspal, beton, dsb)','bobot'=>0.15,'tipe'=>'cost','status'=>'aktif'],
            ['nama'=>'Kondisi Permukaan Jalan','deskripsi'=>'Kondisi umum fisik jalan','bobot'=>0.20,'tipe'=>'benefit','status'=>'aktif'],
        ];

        foreach ($items as $it) {
            Kriteria::create($it);
        }
    }
}