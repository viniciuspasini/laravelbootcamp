<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ForgotPasswordController;
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
});


Route::controller(LoginController::class)->group(function () {

    Route::middleware('guest')
        ->prefix('login')
        ->name('login.')
        ->group(function () {

        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');

    });

    Route::middleware('auth')->group(function () {
        Route::delete('/logout', 'destroy')->name('login.destroy')->middleware('auth');
    });

});

Route::controller(ForgotPasswordController::class)
    ->middleware('guest')
    ->prefix('forgot-password')
    ->name('password.')
    ->group(function () {

    Route::get('/', 'index')->name('request');
    Route::post('/', 'store')->name('email');
    Route::get('/{token}', 'edit')->name('reset');
    Route::put('/', 'update')->name('update');

});

Route::fallback(function () {
   return view('errors.404', ['title' => '404']);
});


