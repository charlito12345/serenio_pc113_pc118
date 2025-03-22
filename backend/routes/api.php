<?php

use Illuminate\Support\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;

Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users', [StudentController::class, 'create']);

Route::middleware('auth:sanctum')->group(function(){
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/search', [StudentController::class, 'search']);
Route::post('/students', [EmployeeController::class, 'create']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [EmployeeController::class, 'delete']);
Route::post('/students/login', [StudentController::class, 'login']);

Route::get('/employees', [EmployeeController::class, 'employee']); 
Route::get('/employees/search', [StudentController::class, 'search']);
Route::post('/employees', [EmployeeController::class, 'create']);
Route::put('/employees/{id}', [StudentController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'delete']); 
Route::post('/employees/search', [StudentController::class, 'login']);



});