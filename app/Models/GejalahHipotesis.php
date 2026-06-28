<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GejalahHipotesis extends Model
{
    protected $table = 'gejala_hipotesis';

    protected $fillable = ['gejala_id', 'hipotesis_id', 'nilai_pakar'];

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }

    public function hipotesis()
    {
        return $this->belongsTo(Hipotesis::class);
    }
}