<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::controller(HomeController::class)->name('home.')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::resource('courses', CoursesController::class);
    Route::resource('course', CourseController::class);
    Route::resource('lesson', LessonController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('checkout', CheckoutController::class);
    Route::delete('/logout', [LoginController::class, 'destroy'])->name('login.destroy')->middleware('auth');

});


Route::controller(LoginController::class)->middleware('guest')->group(function () {

    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store')->name('login.store');

});


