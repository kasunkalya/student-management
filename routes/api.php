<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


Route::get('/students', [StudentController::class, 'studentList']);
Route::get('/students/{id}', [StudentController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/students', [StudentController::class, 'store']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']); 
});
