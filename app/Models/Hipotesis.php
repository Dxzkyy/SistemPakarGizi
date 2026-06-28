<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hipotesis extends Model
{
    protected $table = 'hipotesis';

    protected $fillable = ['kode', 'nama', 'deskripsi', 'rekomendasi'];

    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'gejala_hipotesis', 'hipotesis_id', 'gejala_id')
                    ->withPivot('nilai_pakar')
                    ->withTimestamps();
    }
}