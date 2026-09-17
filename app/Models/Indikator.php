<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $table = 'indikator';

    protected $fillable = [
        'kelompok_indikator_id',
        'nama_indikator',
        'slug',
        'satuan',
        'tipe_data',
        'deskripsi',
    ];

    public function kelompok()
    {
        return $this->belongsTo(
            KelompokIndikator::class,
            'kelompok_indikator_id'
        );
    }

    public function dataIndikator()
    {
        return $this->hasMany(
            DataIndikator::class,
            'indikator_id'
        );
    }

    public function kategori()
    {
        return $this->hasMany(
            KategoriIndikator::class,
            'indikator_id'
        );
    }
}