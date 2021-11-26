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
<<<<<<< HEAD

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




=======
Route::resource("/catalog",\App\Http\Controllers\CatalogController::class);

Route::resource("/material",\App\Http\Controllers\MaterialController::class);
Route::post('/material/store', [App\Http\Controllers\MaterialController::class, 'storeMaterial']);
Route::get("/searchCatalog/{id}",[App\Http\Controllers\MaterialController::class, 'searchCatalog']);
Route::get("/materialfilter/{id}",[App\Http\Controllers\MaterialController::class, 'materialfilter']);
Route::get("/searchMaterialsap",[App\Http\Controllers\MaterialController::class, 'searchMaterialsap']);
Route::get("/showMaterial/{id}",[App\Http\Controllers\MaterialController::class, 'showMaterial']);
>>>>>>> 33b531ef04be3376fd31d4cd3addf8af73e67dd5
