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




Route::resource("/catalog",\App\Http\Controllers\CatalogController::class);

Route::resource("/material",\App\Http\Controllers\MaterialController::class);
Route::post('/material/store', [App\Http\Controllers\MaterialController::class, 'storeMaterial']);
Route::get("/searchCatalog/{id}",[App\Http\Controllers\MaterialController::class, 'searchCatalog']);
Route::get("/materialfilter/{id}",[App\Http\Controllers\MaterialController::class, 'materialfilter']);
Route::get("/searchMaterialsap",[App\Http\Controllers\MaterialController::class, 'searchMaterialsap']);
Route::get("/showMaterial/{id}",[App\Http\Controllers\MaterialController::class, 'showMaterial']);
Route::resource("/entryvoucher",\App\Http\Controllers\EntryVoucherController::class);
Route::get("/searchGuide/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchGuide']);
Route::get("/searchProduct/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchProduct']);
Route::get("/reportEntries",[App\Http\Controllers\EntryVoucherController::class, 'reportEntries']);
Route::post("/reportEntriesSearch",[App\Http\Controllers\EntryVoucherController::class, 'reportEntriesSearch']);
Route::get("/reportEntriesPDF",[App\Http\Controllers\EntryVoucherController::class, 'reportEntriesPDF']);


Route::get("/searchLocationsEntries/{id}",[App\Http\Controllers\EntryVoucherController::class, 'searchLocationsEntries']);
//charts
Route::get("/entryVoucherToday",[App\Http\Controllers\EntryVoucherController::class, 'entryVoucherToday']);
Route::get("/entryVoucherMonth",[App\Http\Controllers\EntryVoucherController::class, 'chartEntryMonth']);
Route::get("/chartDonutTopMaterials",[App\Http\Controllers\EntryVoucherController::class, 'chartDonutTopMaterials']);

Route::get("/entriesDeleted",[App\Http\Controllers\EntryVoucherController::class, 'entriesDeleted']);
Route::get("/searchEntryVoucherProv",[App\Http\Controllers\EntryVoucherController::class, 'searchEntryVoucherProv']);
Route::get("/searchEntryVoucherDate",[App\Http\Controllers\EntryVoucherController::class, 'searchEntryVoucherDate']);
Route::get("/entryVoucherPDF/{id}",[App\Http\Controllers\EntryVoucherController::class, 'entryVoucherPDF']);

Route::resource("/supplier",\App\Http\Controllers\SupplierController::class);
Route::get("/searchSupplier",[App\Http\Controllers\SupplierController::class, 'searchSupplier']);
Route::get('/supplierDisabledRequest', [App\Http\Controllers\SupplierController::class, "SupplierRequestDisabled"]);
Route::get('/supplierSearchByRUC', [App\Http\Controllers\SupplierController::class, "supplierSearchByRUC"]);
Route::get('/supplierSearchByName', [App\Http\Controllers\SupplierController::class, "supplierSearchByName"]);
Route::get('/reportsSuppliers', [App\Http\Controllers\SupplierController::class, "reportsSuppliers"]);
Route::post('/updateContact', [App\Http\Controllers\SupplierController::class, "updateContact"]);
Route::get('/forProv', [App\Http\Controllers\SupplierController::class, "forProv"]);
Route::get('/forProvData', [App\Http\Controllers\SupplierController::class, "forProvData"]);
Route::get('/forProvDataPDF', [App\Http\Controllers\SupplierController::class, "forProvDataPDF"]);

//forProvData
//Los siguientes tengo que ver si se usaran//
Route::get("/searchPhone{id}",[App\Http\Controllers\SupplierController::class, 'searchPhone']);
Route::get("/searchEmail/{id}",[App\Http\Controllers\SupplierController::class, 'searchEmail']);
Route::get("/searchAddress/{id}",[App\Http\Controllers\SupplierController::class, 'searchAddress']);

