<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomrController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\BookingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


 Route::prefix('admin')
 ->controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('forget', 'forgetPassword');
    Route::post('reset', 'resetPassword')->name('reset');
    Route::post('logout', 'logout');


 })->group(function (){

    Route::resource('customr', CustomrController::class , ['names' => 'customr']);

    Route::resource('centres', CentreController::class , ['names' => 'centres']);


 });

 Route::prefix('customr')->controller(CustomrController::class)->group(function () {

    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('forget', 'forgetPassword');
    Route::post('reset', 'resetPassword')->name('reset');
    Route::post('logout', 'logout');

    Route::resource('booking', BookingController::class , ['names' => 'booking']);
   //  Route::post('time', [BookingController::class, 'time'])->name('timecalc');
    Route::get('confirm/{check}', [BookingController::class, 'checkbooking'])->name('check');
 });

// Route::middleware('auth:user_api')->controller(AuthController::class)->group(function () {

//     Route::post('logout', 'logout');
// });


