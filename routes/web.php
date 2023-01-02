<?php

use App\Http\Controllers\KavaController;
use Illuminate\Support\Facades\Route;

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
});

Route::get('generateClosing/{id}', [KavaController::class, "generateClosings"])->middleware('auth:api');
//{"participant_id":"424","treaty_account_id":"115","type":0,"emp_id":"11"}
