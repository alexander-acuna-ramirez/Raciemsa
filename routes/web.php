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

Route::resource("/CorrectionRequest",\App\Http\Controllers\CorrectionRequestController::class);
Route::get('/CorrectionRequest/change_status/{codigo}',[App\Http\Controllers\CorrectionRequestController::class,'change_status'])
->name('change.status.Crequest');
Route::get("/CorrectionRequest/searchGuide/{id}",[App\Http\Controllers\CorrectionRequestController::class, 'searchGuide']);
Route::get("/CorrectionRequest/searchProduct/{id}",[App\Http\Controllers\CorrectionRequestController::class, 'searchProduct']);
Route::get("/searchRequestCorrection",[App\Http\Controllers\CorrectionRequestController::class, 'searchRequest']);
Route::get("/searchbyDateCorrection",[App\Http\Controllers\CorrectionRequestController::class, 'searchbyDate']);
Route::get('/CorrectionRequestdisabled', [App\Http\Controllers\CorrectionRequestController::class, "disabledCorrectionRequest"]);

Route::get("/correctionRequestPDF/{id}",[App\Http\Controllers\CorrectionRequestController::class, 'CorrectionRequestPDF']);
Route::get("/reportCorrections",[App\Http\Controllers\CorrectionRequestController::class, 'reportCorrections']);