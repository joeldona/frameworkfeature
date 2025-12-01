<?php

use Illuminate\Support\Facades\Route;
// 👇 TIENES QUE AÑADIR ESTAS LÍNEAS IMPORTANTE
use App\Http\Controllers\PostController;
use App\Http\Controllers\CourseController; 
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de tus CRUDs
Route::resource('posts', PostController::class);
Route::resource('courses', CourseController::class);
Route::resource('students', StudentController::class);