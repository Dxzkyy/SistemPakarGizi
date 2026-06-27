<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';
    protected $fillable = [
        'user_id', 'tipe', 'status',
        'hipotesis_id', 'nilai_bayes', 'catatan_pakar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hipotesis()
    {
        return $this->belongsTo(Hipotesis::class);
    }

    public function konsultasiGejala()
    {
        return $this->hasMany(KonsultasiGejala::class);
    }

    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'konsultasi_gejala')
                    ->withTimestamps();
    }
}