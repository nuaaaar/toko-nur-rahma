<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function()
{
    Route::get('login', [Auth\LoginController::class, 'index']);

    Route::post('login', [Auth\LoginController::class, 'login'])->name('login');

    Route::get('forgot-password', [Auth\ForgotPasswordController::class, 'index'])->name('password.request');

    Route::post('forgot-password', [Auth\ForgotPasswordController::class, 'sentResetLinkEmail'])->name('password.email');

    Route::get('reset-password/{token}', [Auth\ResetPasswordController::class, 'index'])->name('password.reset');

    Route::post('reset-password', [Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});


Route::middleware('auth')->group(function()
{
    Route::get('logout', [Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('dashboard')->name('dashboard.')->group(function()
    {
    });
});

