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
Route::get('courses/export', [CourseController::class, 'export'])->name('courses.export');
Route::resource('courses', CourseController::class);
Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
Route::resource('students', StudentController::class);
