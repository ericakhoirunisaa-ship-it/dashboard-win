<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    protected $table = 'periode';

    protected $fillable = [
        'tahun',
        'bulan',
        'nama_periode',
        'frekuensi',
    ];

    public function dataIndikator(): HasMany
    {
        return $this->hasMany(DataIndikator::class);
    }
}