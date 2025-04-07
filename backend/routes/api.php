<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;

Route::post('/users/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

// Route::middleware('auth:sanctum')->group(function(){

Route::get('/studentsList', [StudentController::class, 'list']);
Route::get('/studentsSearch', [StudentController::class, 'search']);
Route::post('/studentscreate', [StudentController::class, 'studentsCreate']);
Route::put('/students/{id}', [StudentController::class, 'studentsUpdate']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
// Route::post('/students/login', [StudentController::class, 'login']);

Route::get('/employees', [EmployeeController::class, 'employee']); 
Route::get('/employees/search', [StudentController::class, 'search']);
Route::post('/employees', [EmployeeController::class, 'create']);
Route::put('/employees/{id}', [StudentController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'delete']); 
Route::post('/employees/search', [StudentController::class, 'login']);

// });
    