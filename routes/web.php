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
Route::post('/material/store', [App\Http\Controllers\CatalogController::class, 'storeMaterial']);
Route::get('/material/create', [App\Http\Controllers\CatalogController::class, 'createMaterial']);
Route::get('/material/edit', [App\Http\Controllers\CatalogController::class, 'editMaterial']);
Route::post('/material/update', [App\Http\Controllers\CatalogController::class, 'updateMaterial']);


