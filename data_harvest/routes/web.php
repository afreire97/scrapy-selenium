<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelojController;
use App\Http\Controllers\SpiderController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('/dashboard', [WebController::class, 'indexAction'])->name('dashboard');


    //RELOJES GUARDADOS


    Route::get('/mis-relojes', [RelojController::class, 'index'])->name('relojes.index');
    Route::post('/guardar-reloj', [RelojController::class, 'guardarReloj'])->name('guardar-reloj');
    Route::delete('/eliminar-reloj', [RelojController::class, 'destroy'])->name('relojes.destroy');





});

require __DIR__.'/auth.php';
