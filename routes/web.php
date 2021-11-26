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

Route::resource("/material",\App\Http\Controllers\MaterialController::class);
Route::post('/material/store', [App\Http\Controllers\MaterialController::class, 'storeMaterial']);
Route::get("/searchCatalog/{id}",[App\Http\Controllers\MaterialController::class, 'searchCatalog']);
Route::get("/materialfilter/{id}",[App\Http\Controllers\MaterialController::class, 'materialfilter']);
Route::get("/searchMaterialsap",[App\Http\Controllers\MaterialController::class, 'searchMaterialsap']);
Route::get("/showMaterial/{id}",[App\Http\Controllers\MaterialController::class, 'showMaterial']);
