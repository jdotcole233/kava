<?php

use App\Http\Controllers\KavaController;
use App\Http\Controllers\kavaPasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('generateClosing/{id}', [KavaController::class, "generateClosings"])->middleware('auth:api');
Route::get('treatyCreditNotes/{id}', [KavaController::class, "treatyCreditNotes"])->middleware('auth:api');

Route::get('reset-password/{token}', [kavaPasswordResetController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [kavaPasswordResetController::class, "passwordReset"])->middleware('guest');
