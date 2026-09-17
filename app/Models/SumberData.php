<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SumberData extends Model
{
    protected $table = 'sumber_data';

    protected $fillable = [
        'nama_sumber',
        'url',
        'keterangan',
    ];

    public function dataIndikator(): HasMany
    {
        return $this->hasMany(DataIndikator::class);
    }
}