<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Metros Cúbicos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial; }
        body { max-width: 680px; margin: 2rem auto; padding: 0 1rem; }
        .card { border: 1px solid #ddd; border-radius: 12px; padding: 1rem; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
        label { font-size: .9rem; color: #333; }
        input, select { width: 100%; padding: .6rem .7rem; border: 1px solid #ccc; border-radius: 8px; }
        button { padding: .65rem 1rem; border: 0; border-radius: 10px; cursor: pointer; }
        .primary { background: #111827; color: white; }
        .muted { color:#6b7280; font-size:.9rem; }
        .error { color: #b91c1c; font-size: .85rem; }
        .result { background:#f9fafb; padding:.75rem 1rem; border-radius:10px; margin-top:.75rem; }
        .badge { display:inline-block; font-size:.75rem; padding:.2rem .5rem; background:#eef2ff; color:#3730a3; border-radius:999px; }
    </style>
</head>
<body>
    <h1>Calculadora de Metros Cúbicos</h1>
    <p class="muted">Ingresa largo, ancho y alto en la misma unidad. El resultado se entrega en m³.</p>

    <div class="card">
        <form method="POST" action="{{ route('volumen.calculate') }}">
            @csrf
            <div class="row">
                <div>
                    <label for="largo">Largo</label>
                    <input type="number" step="any" name="largo" id="largo" value="{{ old('largo') }}">
                    @error('largo') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="ancho">Ancho</label>
                    <input type="number" step="any" name="ancho" id="ancho" value="{{ old('ancho') }}">
                    @error('ancho') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row" style="margin-top:.75rem">
                <div>
                    <label for="alto">Alto</label>
                    <input type="number" step="any" name="alto" id="alto" value="{{ old('alto') }}">
                    @error('alto') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="unidad">Unidad</label>
                    <select name="unidad" id="unidad">
                        <option value="m"  {{ old('unidad','m')  === 'm'  ? 'selected' : '' }}>metros (m)</option>
                        <option value="cm" {{ old('unidad') === 'cm' ? 'selected' : '' }}>centímetros (cm)</option>
                        <option value="mm" {{ old('unidad') === 'mm' ? 'selected' : '' }}>milímetros (mm)</option>
                    </select>
                    @error('unidad') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row" style="margin-top:.75rem">
                <div>
                    <label for="decimales">Decimales (0–6)</label>
                    <input type="number" name="decimales" id="decimales" min="0" max="6" value="{{ old('decimales', 3) }}">
                    @error('decimales') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div style="display:flex; align-items:end; justify-content:end">
                    <button class="primary" type="submit">Calcular</button>
                </div>
            </div>
        </form>

        @if (session('resultado') !== null)
            <div class="result">
                <strong>Resultado:</strong>
                <div style="margin-top:.35rem; font-size:1.25rem;">
                    {{ number_format(session('resultado'), old('decimales', 3), ',', '.') }} <span class="badge">m³</span>
                </div>
                <div class="muted" style="margin-top:.35rem;">
                    (sin redondeo: {{ session('m3_raw') }})
                </div>
            </div>
        @endif
    </div>

    <p class="muted" style="margin-top:1rem">
        Fórmula: <code>volumen = largo × ancho × alto</code> (convertidos a metros).
    </p>
</body>
</html>
