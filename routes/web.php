<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activity.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/cabinet', [MasterClassController::class, 'index'])->name('cabinet');
    Route::get('/master-classes/create', [MasterClassController::class, 'create'])->name('master-classes.create');
    Route::post('/master-classes', [MasterClassController::class, 'store'])->name('master-classes.store');
    Route::get('/master-classes/{masterClass}/edit', [MasterClassController::class, 'edit'])->name('master-classes.edit');
    Route::put('/master-classes/{masterClass}', [MasterClassController::class, 'update'])->name('master-classes.update');

    Route::get('/enroll/{masterClass}', [EnrollmentController::class, 'confirm'])->name('enrollment.confirm');
    Route::post('/enroll/{masterClass}', [EnrollmentController::class, 'store'])->name('enrollment.store');
});
