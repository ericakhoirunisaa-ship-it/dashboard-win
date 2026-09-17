<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokIndikator extends Model
{
    protected $table = 'kelompok_indikator';

    protected $fillable = [
        'nama_kelompok',
        'slug',
    ];

    public function indikator()
    {
        return $this->hasMany(
            Indikator::class,
            'kelompok_indikator_id'
        );
    }
}