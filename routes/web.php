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
Route::resource("/guide",\App\Http\Controllers\GuideController::class);

Route::get("/searchProveedor/{id}",[App\Http\Controllers\GuideController::class, 'searchProveedor']);
Route::get("/searchGuide",[App\Http\Controllers\GuideController::class, 'searchGuide']);
Route::get("/searchGuideDisable",[App\Http\Controllers\GuideController::class, 'searchGuideDisable']);
Route::get("/searchbyDate",[App\Http\Controllers\GuideController::class, 'searchbyDate']);
Route::get("/disableGuides",[App\Http\Controllers\GuideController::class, 'disableGuides']);
Route::get("/searchbyDateDisable",[App\Http\Controllers\GuideController::class, 'searchbyDateDisable']);
Route::get("/report",[App\Http\Controllers\GuideController::class, 'report']);
Route::get("/downloadPDF",[App\Http\Controllers\GuideController::class, 'downloadPDF'])->name('downloadPDF');




