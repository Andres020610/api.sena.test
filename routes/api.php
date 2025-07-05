<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\ApprenticeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para computers
Route::get('computers', [ComputerController::class, 'index'])->name('api.v1.computers.index');
Route::post('computers', [ComputerController::class, 'store'])->name('api.v1.computers.store');
Route::get('computers/{computer}', [ComputerController::class, 'show'])->name('api.v1.computers.show');

// Rutas para aprendices
Route::get('apprentices', [ApprenticeController::class, 'index'])->name('api.v1.apprentices.index');
Route::post('apprentices', [ApprenticeController::class, 'store'])->name('api.v1.apprentices.store');
Route::get('apprentices/{apprentice}', [ApprenticeController::class, 'show'])->name('api.v1.apprentices.show');
