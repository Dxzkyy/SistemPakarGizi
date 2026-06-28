<?php

namespace App\Services;

use App\Models\GejalahHipotesis;
use App\Models\Hipotesis;

class BayesService
{
    public function hitung(array $gejalaDipilih): array
    {
        $semuaHipotesis = Hipotesis::all();
        $hasil = [];

        foreach ($semuaHipotesis as $hipotesis) {
            // Ambil gejala yang cocok dengan hipotesis ini
            $gejalaCocok = GejalahHipotesis::where('hipotesis_id', $hipotesis->id)
                ->whereIn('gejala_id', $gejalaDipilih)
                ->get();

            if ($gejalaCocok->isEmpty()) continue;

            // Step 1 - Hitung ΣH
            $totalH = $gejalaCocok->sum('nilai_pakar');

            // Step 2 - Hitung P[H] tiap gejala
            $pH = $gejalaCocok->map(fn($g) => $g->nilai_pakar / $totalH);

            // Step 3 - Hitung P(E) = Σ nilai_pakar * P[H]
            $pE = 0;
            foreach ($gejalaCocok as $i => $g) {
                $pE += $g->nilai_pakar * $pH[$i];
            }

            // Step 4 - Hitung P(H|E)
            $pHE = $gejalaCocok->map(fn($g, $i) => 
                ($g->nilai_pakar * $pH[$i]) / $pE
            );

            // Step 5 - Hitung Hasil Diagnosa (HD)
            $hd = 0;
            foreach ($gejalaCocok as $i => $g) {
                $hd += $pHE[$i] * $g->nilai_pakar;
            }

            $hasil[$hipotesis->id] = [
                'hipotesis'  => $hipotesis,
                'nilai_bayes' => round($hd * 100, 2),
            ];
        }

        // Urutkan dari nilai tertinggi
        usort($hasil, fn($a, $b) => $b['nilai_bayes'] <=> $a['nilai_bayes']);

        return $hasil;
    }
}