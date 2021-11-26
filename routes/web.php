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
Route::get("/RequestForReinstatement/{requestForReinstatement}/edit",[App\Http\Controllers\RequestForReinstatementController::class, "edit"])->name('RequestForReinstatement.edit');
Route::get("/RequestForReinstatement",[App\Http\Controllers\RequestForReinstatementController::class,'index'])->name('RequestForReinstatement.index');
Route::get("/RequestForReinstatement/create",[App\Http\Controllers\RequestForReinstatementController::class,'create'])->name('RequestForReinstatement.create');
Route::post("/RequestForReinstatement",[App\Http\Controllers\RequestForReinstatementController::class, 'search'])->name('RequestForReinstatement.search');
Route::post("/RequestForReinstatement/disabled",[App\Http\Controllers\RequestForReinstatementController::class, 'searchdisabled'])->name('RequestForReinstatement.searchdisabled');
Route::get("/RequestForReinstatement/{requestForReinstatement}/showRequirement",[App\Http\Controllers\RequestForReinstatementController::class, "showRequirement"])->name('RequestForReinstatement.showrequirement');
Route::get("/RequestForReinstatement/disabled/{requestForReinstatement}/showRequirementDisabled",[App\Http\Controllers\RequestForReinstatementController::class, "showRequirementDisabled"])->name('RequestForReinstatement.showrequirementdisabled');
Route::post("/RequestForReinstatement/save",[\App\Http\Controllers\RequestForReinstatementController::class, 'save'])->name('RequestForReinstatement.save');
Route::get("/RequestForReinstatement/getStates/{id}",[App\Http\Controllers\RequestForReinstatementController::class, 'getStates'])->name('RequestForReinstatement.states');
Route::get("/RequestForReinstatement/{requestForReinstatement}/delete",[App\Http\Controllers\RequestForReinstatementController::class, 'delete'])->name('RequestForReinstatement.delete');
Route::get("/RequestForReinstatement/disabled/{requestForReinstatement}/enable",[App\Http\Controllers\RequestForReinstatementController::class, 'enable'])->name('RequestForReinstatement.enable');
Route::get("/RequestForReinstatement/{requestForReinstatement}/export",[App\Http\Controllers\RequestForReinstatementController::class, 'export'])->name('RequestForReinstatement.export');
Route::get("/RequestForReinstatement/disabled",[App\Http\Controllers\RequestForReinstatementController::class, 'disabled']);
