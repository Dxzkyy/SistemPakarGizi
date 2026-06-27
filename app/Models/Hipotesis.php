<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hipotesis extends Model
{
    protected $table = 'hipotesis';
    protected $fillable = ['kode', 'nama', 'deskripsi', 'rekomendasi'];

    public function gejalahHipotesis()
    {
        return $this->hasMany(GejalahHipotesis::class);
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class);
    }
}