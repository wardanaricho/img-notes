<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokalisController;

Route::get('/a', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('apm');
});
Route::get('/test-img', function () {
    return view('img');
});

Route::get('/lokalis/create', [LokalisController::class, 'create'])->name('lokalis.create');
Route::post('/lokalis', [LokalisController::class, 'store'])->name('lokalis.store');
Route::get('/lokalis/{id}', [LokalisController::class, 'show'])->name('lokalis.show');
Route::get('/lokalis/{id}/edit', [LokalisController::class, 'edit'])->name('lokalis.edit');
Route::put('/lokalis/{id}/update/', [LokalisController::class, 'update'])->name('lokalis.update');
