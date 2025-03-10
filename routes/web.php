<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;


    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/', function () {
        return view('auth.login');
    })->name('login');



    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

