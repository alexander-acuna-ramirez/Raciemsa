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
Route::get("/searchGuide/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchGuide']);
Route::get("/searchProduct/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchProduct']);
Route::get("/searchLocationsEntries/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchLocationsEntries']);
//charts
Route::get("/entryVoucherToday",[App\Http\Controllers\EntryVoucherController::class, 'entryVoucherToday']);
Route::get("/entryVoucherMonth",[App\Http\Controllers\EntryVoucherController::class, 'chartEntryMonth']);
Route::get("/chartDonutTopMaterials",[App\Http\Controllers\EntryVoucherController::class, 'chartDonutTopMaterials']);

Route::get("/entriesDeleted",[App\Http\Controllers\EntryVoucherController::class, 'entriesDeleted']);
Route::get("/searchEntryVoucherProv",[App\Http\Controllers\EntryVoucherController::class, 'searchEntryVoucherProv']);
Route::get("/searchEntryVoucherDate",[App\Http\Controllers\EntryVoucherController::class, 'searchEntryVoucherDate']);
Route::get("/entryVoucherPDF/{id}",[App\Http\Controllers\EntryVoucherController::class, 'entryVoucherPDF']);
