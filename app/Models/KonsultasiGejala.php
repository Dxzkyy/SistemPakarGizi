<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonsultasiGejala extends Model
{
    protected $table = 'konsultasi_gejala';
    protected $fillable = ['konsultasi_id', 'gejala_id'];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}