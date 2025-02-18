<?php

use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/buscar-endereco', [EnderecoController::class, 'getEnderecos'])->name('enderecos.buscar');

Route::get('/endereco', [EnderecoController::class, 'enderecos'])->name('enderecos.abrir');




require __DIR__.'/auth.php';
