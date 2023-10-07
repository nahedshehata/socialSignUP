
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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



Auth::routes();
Route::get('/home', 'App\Http\Controllers\HomeController@index')->middleware('auth');

// Google login
Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirect'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

// facebook login
Route::get('auth/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);
