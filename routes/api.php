<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\TrainingCenterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\ComputerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para docentes
Route::get('teachers', [TeacherController::class, 'index'])->name('api.v1.teachers.index');
Route::post('teachers', [TeacherController::class, 'store'])->name('api.v1.teachers.store');
Route::get('teachers/{teacher}', [TeacherController::class, 'show'])->name('api.v1.teachers.show');
Route::put('teachers/{teacher}', [TeacherController::class, 'update'])->name('api.v1.teachers.update');
Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy'])->name('api.v1.teachers.destroy');

// Rutas para áreas
Route::get('areas', [AreaController::class, 'index'])->name('api.v1.areas.index');
Route::post('areas', [AreaController::class, 'store'])->name('api.v1.areas.store');
Route::get('areas/{area}', [AreaController::class, 'show'])->name('api.v1.areas.show');
Route::put('areas/{area}', [AreaController::class, 'update'])->name('api.v1.areas.update');
Route::delete('areas/{area}', [AreaController::class, 'destroy'])->name('api.v1.areas.destroy');

// Rutas para centros de formación
Route::get('training-centers', [TrainingCenterController::class, 'index'])->name('api.v1.training-centers.index');
Route::post('training-centers', [TrainingCenterController::class, 'store'])->name('api.v1.training-centers.store');
Route::get('training-centers/{trainingCenter}', [TrainingCenterController::class, 'show'])->name('api.v1.training-centers.show');
Route::put('training-centers/{trainingCenter}', [TrainingCenterController::class, 'update'])->name('api.v1.training-centers.update');
Route::delete('training-centers/{trainingCenter}', [TrainingCenterController::class, 'destroy'])->name('api.v1.training-centers.destroy');

// Rutas para cursos
Route::get('courses', [CourseController::class, 'index'])->name('api.v1.courses.index');
Route::post('courses', [CourseController::class, 'store'])->name('api.v1.courses.store');
Route::get('courses/{course}', [CourseController::class, 'show'])->name('api.v1.courses.show');
Route::put('courses/{course}', [CourseController::class, 'update'])->name('api.v1.courses.update');
Route::delete('courses/{course}', [CourseController::class, 'destroy'])->name('api.v1.courses.destroy');

// Rutas para aprendices
Route::get('apprentices', [ApprenticeController::class, 'index'])->name('api.v1.apprentices.index');
Route::post('apprentices', [ApprenticeController::class, 'store'])->name('api.v1.apprentices.store');
Route::get('apprentices/{apprentice}', [ApprenticeController::class, 'show'])->name('api.v1.apprentices.show');
Route::put('apprentices/{apprentice}', [ApprenticeController::class, 'update'])->name('api.v1.apprentices.update');
Route::delete('apprentices/{apprentice}', [ApprenticeController::class, 'destroy'])->name('api.v1.apprentices.destroy');

// Rutas para computadores
Route::get('computers', [ComputerController::class, 'index'])->name('api.v1.computers.index');
Route::post('computers', [ComputerController::class, 'store'])->name('api.v1.computers.store');
Route::get('computers/{computer}', [ComputerController::class, 'show'])->name('api.v1.computers.show');
Route::put('computers/{computer}', [ComputerController::class, 'update'])->name('api.v1.computers.update');
Route::delete('computers/{computer}', [ComputerController::class, 'destroy'])->name('api.v1.computers.destroy');
