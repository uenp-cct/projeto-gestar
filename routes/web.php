<?php

use App\Http\Controllers\GestanteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/about', function () {
    return view('about');
});


Route::get('/gestantes/cadastrar', [GestanteController::class, 'create'])->name('gestantes.create');
Route::post('/gestantes/cadastrar', [GestanteController::class, 'store'])->name('gestantes.store');
