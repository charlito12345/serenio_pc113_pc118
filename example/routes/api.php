<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;

Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/students', [StudentController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
Route::get('/employees/search', [EmployeeController::class, 'search']); 
Route::get('/students/search', [StudentController::class, 'search']);