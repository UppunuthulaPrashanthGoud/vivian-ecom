<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\WebAdmin\LoginController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContactMessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Serve Vue.js application for all frontend routes
Route::get('/{any}', function () {
    return view('website');
})->where('any', '.*');

// API routes for Vue.js frontend
Route::prefix('api')->group(function () {
    // Master data
    Route::get('/master', [MasterController::class, 'index'])->name('api.master');
    
    // Courses
    Route::get('/courses', [CourseController::class, 'index'])->name('api.courses');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('api.courses.show');
    
    // Contact
    Route::post('/contact', [ContactMessageController::class, 'submit'])->name('api.contact');
    
    // Authentication routes
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [LoginController::class, 'instructorRegister'])->name('register');
    Route::post('/register', [LoginController::class, 'instructorAuthenticate'])->name('register.authenticate');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // User verification routes
    Route::get('/verification', [UserVerificationController::class, 'index'])->name('verification.index');
    Route::get('/verification/resend/{email}', [UserVerificationController::class, 'sendotp'])->name('verification.resend.otp');
    Route::post('/verification/{email}', [UserVerificationController::class, 'verify'])->name('verification.verify');
});
