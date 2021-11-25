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
Route::resource("/supplier",\App\Http\Controllers\SupplierController::class);
/*Route::resource("/address",\App\Http\Controllers\AddressController::class);
Route::resource("/email",\App\Http\Controllers\EmailController::class);
Route::resource("/phone",\App\Http\Controllers\PhoneController::class);*/
//Route::get("/searchSupplier{id}",[App\Http\Controllers\SupplierController::class, 'searchSupplier']);

Route::get("/searchSupplier",[App\Http\Controllers\SupplierController::class, 'searchSupplier']);
Route::get('/supplierDisabledRequest', [App\Http\Controllers\SupplierController::class, "SupplierRequestDisabled"]);

//Los siguientes tengo que ver si se usaran//
Route::get("/searchPhone{id}",[App\Http\Controllers\SupplierController::class, 'searchPhone']);
Route::get("/searchEmail/{id}",[App\Http\Controllers\SupplierController::class, 'searchEmail']);
Route::get("/searchAddress/{id}",[App\Http\Controllers\SupplierController::class, 'searchAddress']);
