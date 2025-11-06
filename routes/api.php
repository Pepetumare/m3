<?

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/volumen', function (Request $request) {
    $data = $request->validate([
        'largo'  => ['required','numeric','gt:0'],
        'ancho'  => ['required','numeric','gt:0'],
        'alto'   => ['required','numeric','gt:0'],
        'unidad' => ['required','in:m,cm,mm'],
    ]);

    $factor = ['m'=>1,'cm'=>0.01,'mm'=>0.001][$data['unidad']];
    $m3 = ($data['largo']*$factor) * ($data['ancho']*$factor) * ($data['alto']*$factor);

    return response()->json([
        'm3' => $m3,
        'redondeado' => round($m3, 3),
    ]);
});
