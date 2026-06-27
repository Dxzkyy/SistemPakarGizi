<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejala';
    protected $fillable = ['kode', 'nama_gejala', 'keterangan', 'tampil_ke_user'];

    protected $casts = [
        'tampil_ke_user' => 'boolean',
    ];

    public function gejalahHipotesis()
    {
        return $this->hasMany(GejalahHipotesis::class);
    }

    public function hipotesis()
    {
        return $this->belongsToMany(Hipotesis::class, 'gejala_hipotesis')
                    ->withPivot('nilai_pakar')
                    ->withTimestamps();
    }
}