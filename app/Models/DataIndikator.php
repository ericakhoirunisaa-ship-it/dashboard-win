<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataIndikator extends Model
{
    protected $table = 'data_indikator';

    protected $fillable = [
        'indikator_id',
        'kategori_indikator_id',
        'periode_id',
        'sumber_data_id',
        'nilai',
        'catatan',
    ];

    protected $casts = [
        'nilai' => 'float',
    ];

    public function indikator()
    {
        return $this->belongsTo(
            Indikator::class,
            'indikator_id'
        );
    }

    public function kategori()
    {
        return $this->belongsTo(
            KategoriIndikator::class,
            'kategori_indikator_id'
        );
    }

    public function periode()
    {
        return $this->belongsTo(
            Periode::class,
            'periode_id'
        );
    }

    public function sumberData()
    {
        return $this->belongsTo(
            SumberData::class,
            'sumber_data_id'
        );
    }
}