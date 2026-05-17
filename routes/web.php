<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FrenchCompanyController;
use App\Http\Controllers\BrazilJobOfferController;
use App\Http\Controllers\ScriptRunController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Jobs listing
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::post('/jobs/{job}/candidature', [JobController::class, 'updateCandidature'])->name('jobs.updateCandidature');

Route::resource('companies', FrenchCompanyController::class)->only(['index', 'create', 'store', 'show']);
Route::resource('brazil-offers', BrazilJobOfferController::class)->only(['index', 'create', 'store', 'show']);

Route::get('/scripts', [ScriptRunController::class, 'index'])->name('scripts.index');
Route::post('/scripts/{scriptKey}/run', [ScriptRunController::class, 'run'])->name('scripts.run');
