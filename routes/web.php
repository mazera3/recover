<?php

use App\Http\Controllers\LivroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// web.php
Route::get('/importar-livros', [LivroController::class, 'showForm'])->name('importar');
Route::post('/importar-livros', [LivroController::class, 'processarForm'])->name('importar.livros');
