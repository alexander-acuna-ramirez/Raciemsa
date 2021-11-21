<?php

use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource("/catalog",\App\Http\Controllers\CatalogController::class);
Route::resource("/entryvoucher",\App\Http\Controllers\EntryVoucherController::class);
Route::post("/createEntrances",[App\Http\Controllers\EntryVoucherController::class, 'saveEntrances']);
Route::get("/searchGuide/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchGuide']);
Route::get("/searchProduct/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchProduct']);
Route::post("/saveEntries",[App\Http\Controllers\EntryVoucherController::class, 'saveEntries']);
