<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function showForm()
    {
        return view('volumen.form');
    }

    public function calculate(Request $request)
    {
        $data = $request->validate([
            'largo'  => ['required','numeric','gt:0'],
            'ancho'  => ['required','numeric','gt:0'],
            'alto'   => ['required','numeric','gt:0'],
            'unidad' => ['required','in:m,cm,mm'],
            'decimales' => ['nullable','integer','between:0,6'],
        ]);

        // Pasar todo a metros antes de calcular m³
        $factor = match ($data['unidad']) {
            'm'  => 1,
            'cm' => 0.01,
            'mm' => 0.001,
        };

        $l = $data['largo'] * $factor;
        $a = $data['ancho'] * $factor;
        $h = $data['alto']  * $factor;

        $m3 = $l * $a * $h;

        $dec = $data['decimales'] ?? 3;

        return back()->withInput()->with([
            'resultado' => round($m3, $dec),
            'm3_raw'    => $m3,
        ]);
    }
}
