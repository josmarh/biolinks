<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SPAController;
use App\Http\Controllers\PaymentController;

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

Route::group(['prefix' => 'paypal'], function () {
    Route::view('/failed','paypal.failed')->name('paypalFailed');
    Route::view('/successful','paypal.success')->name('paypalSuccessful');
    Route::get('/success', [PaymentController::class, 'paypalSuccess']);
    Route::get('/error', [PaymentController::class, 'paypalError']);
    Route::post('/pay', [PaymentController::class, 'donation'])->name('paypal-payment');
});

Route::get('/{any}', [SPAController::class, 'index'])->where('any', '.*');
