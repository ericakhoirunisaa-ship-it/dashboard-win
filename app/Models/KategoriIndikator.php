<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriIndikator extends Model
{
    protected $table = 'kategori_indikator';

    protected $fillable = [
        'indikator_id',
        'nama_kategori',
        'slug',
        'urutan',
    ];

    public function indikator()
    {
        return $this->belongsTo(
            Indikator::class,
            'indikator_id'
        );
    }

    public function dataIndikator()
    {
        return $this->hasMany(
            DataIndikator::class,
            'kategori_indikator_id'
        );
    }
}