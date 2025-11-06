<?php

use App\Http\Controllers\VolumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/volumen', [VolumeController::class, 'showForm'])->name('volumen.form');
Route::post('/volumen', [VolumeController::class, 'calculate'])->name('volumen.calculate');