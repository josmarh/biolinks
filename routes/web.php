<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SPAController;

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

Route::get('/w/{linkId}', [SPAController::class, 'biolinkPage'])->name('biolink-webpage');
Route::post('/link-password/{settingId}', [SPAController::class, 'linkPasswordValidate'])->name('link-password.validate');
Route::get('/{any}', [SPAController::class, 'index'])->where('any', '.*');
