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
Route::get("/downloadPDFall",[App\Http\Controllers\GuideController::class, 'downloadPDFall'])->name('downloadPDFall');


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

//forProvData
//Los siguientes tengo que ver si se usaran//
Route::get("/searchPhone{id}",[App\Http\Controllers\SupplierController::class, 'searchPhone']);
Route::get("/searchEmail/{id}",[App\Http\Controllers\SupplierController::class, 'searchEmail']);
Route::get("/searchAddress/{id}",[App\Http\Controllers\SupplierController::class, 'searchAddress']);
Route::POST('/material/{id}/delete', [App\Http\Controllers\MaterialController::class, 'delete'])->name('Material.delete');

Route::get("/reportCatalogPDF/{id}",[App\Http\Controllers\CatalogController::class, 'reportCatalogPDF'])->name('Catalog.reportCatalogPDF');

Route::get("/reporteValorizado",[App\Http\Controllers\CatalogController::class, 'reporteValorizado'])->name('Catalog.reporteValorizado');
Route::POST('/catalog/{id}/delete', [App\Http\Controllers\CatalogController::class, 'delete'])->name('Catalog.delete');



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
