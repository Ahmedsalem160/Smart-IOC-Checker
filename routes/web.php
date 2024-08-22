<?php

use App\Http\Controllers\OtxController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SweepController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search-iocs', [OtxController::class, 'showSearchForm'])->name('search.form');
Route::post('/search-iocs', [OtxController::class, 'handleSearch'])->name('search.iocs');
Route::get('/export-iocs/{id}', [ExportController::class, 'export'])->name('export.indicators');
################## Network Sweep ##################
Route::get('/sweeping', [SweepController::class, 'index'])->name('sweep.index');
Route::post('/sweeping', [SweepController::class, 'sweeping'])->name('sweep.search');



Route::get('/otx/search/{query}', [OtxController::class, 'searchPulses']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
