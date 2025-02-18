<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


Route::resource('/', StudentController::class);


Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

