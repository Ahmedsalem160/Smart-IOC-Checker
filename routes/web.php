<?php

use App\Http\Controllers\OtxController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SweepController;
use App\Http\Controllers\ReputationController;
use Illuminate\Support\Facades\Route;
################################## Auth Routes ##################################
Route::get('/auth/login', function () {
    return view('auth.login');
})->name('custom-login');

// Custom registration route
Route::get('/auth/register', function () {
    return view('auth.register');
})->name('custom-register');

// Custom password reset route
Route::get('/auth/reset', function () {
    return view('auth.reset');
})->name('custom-reset');

// Logout 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

################################## End Auth Routes###############################
Route::get('/', function () {
    return view('welcome');
});

Route::get('/search-iocs', [OtxController::class, 'showSearchForm'])->name('search.form');
Route::post('/search-iocs', [OtxController::class, 'handleSearch'])->name('search.iocs');
Route::get('/export-iocs/{id}', [ExportController::class, 'export'])->name('export.indicators');
################## Network Sweep ##################
Route::get('/sweeping', [SweepController::class, 'index'])->name('sweep.index');
Route::post('/sweeping', [SweepController::class, 'sweeping'])->name('sweep.search');
#################  Reputation Check ################
Route::get('/repudation/check', [ReputationController::class, 'index'])->name('repudation.check');
Route::post('/repudation/check', [ReputationController::class, 'checkIocReputation'])->name('repudation.result');



Route::get('/otx/search/{query}', [OtxController::class, 'searchPulses']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
