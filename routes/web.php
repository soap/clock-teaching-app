<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/test', function () {
    return Inertia::render('Test');
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Student routes
Route::get('/student', function () {
    return Inertia::render('StudentMenu');
})->name('student');

Route::get('/student/tell-a-time', function () {
    return Inertia::render('Student');
})->name('student.tell-a-time');

// Teacher routes
Route::get('/teacher', function () {
    return Inertia::render('TeacherMenu');
})->name('teacher');

Route::get('/teacher/tell-a-time', function () {
    return Inertia::render('Teacher');
})->name('teacher.tell-a-time');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
