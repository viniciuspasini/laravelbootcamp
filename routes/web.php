<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home', ['title' => 'Home'])->name('home');
Route::view('/course', 'course', ['title' => 'Course'])->name('course');
Route::view('/lesson', 'lesson', ['title' => 'Lesson'])->name('lesson');
Route::view('/courses', 'courses', ['title' => 'Courses'])->name('courses');
Route::view('/contact', 'contact', ['title' => 'Contact'])->name('contact');
Route::view('/login', 'login', ['title' => 'Login'])->name('login');
Route::view('/checkout', 'checkout', ['title' => 'Checkout'])->name('checkout');
