<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SPAController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MemberAreaController;

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
Route::post('/w/{linkId}/link/logout', [SPAController::class, 'logoutMember'])->name('member-link-logout');
Route::post('/w/{linkId}/link/login', [SPAController::class, 'loginMember'])->name('member-link-login');
Route::post('/w/{linkId}/link/fan-request', [PaymentController::class, 'fanRequest'])->name('fan-request');
Route::post('/w/{linkId}/link/fan-request-auth', [PaymentController::class, 'fanRequestWithAuth'])->name('fan-request-auth');
Route::post('/w/{linkId}/link/product', [PaymentController::class, 'product'])->name('product');
Route::post('/w/{linkId}/link/product-auth', [PaymentController::class, 'productWithAuth'])->name('product-auth');

Route::get('/w/{projectName}/login', [MemberAreaController::class, 'login'])->name('member-login');
Route::get('/w/{projectName}/member-signup', [MemberAreaController::class, 'register'])->name('member-register');
Route::get('/w/{projectName}/library', [MemberAreaController::class, 'library'])->name('member-library');
Route::get('/w/{projectName}/account', [MemberAreaController::class, 'account'])->name('member-account');
Route::get('/w/{projectName}/orders', [MemberAreaController::class, 'orders'])->name('member-orders');
Route::get('/w/{projectName}/post/{slug}', [MemberAreaController::class, 'post'])->name('member-post');
Route::get('/w/{projectName}/{routeName}', [MemberAreaController::class, 'index'])->name('member-index');

Route::post('/w/{projectName}/login', [MemberAreaController::class, 'loginMember'])->name('post-login');
Route::post('/w/{projectName}/signup', [MemberAreaController::class, 'registerMember'])->name('post-register');
Route::post('/w/{projectName}/logout', [MemberAreaController::class, 'logoutMember'])->name('member-logout');
Route::put('/w/{projectName}/account', [MemberAreaController::class, 'updateAccount'])->name('member-account-update');

Route::post('/link-password/{settingId}', [SPAController::class, 'linkPasswordValidate'])->name('link-password.validate');
Route::group(['prefix' => 'paypal'], function () {
    Route::view('/failed','paypal.failed')->name('paypalFailed');
    Route::view('/successful','paypal.success')->name('paypalSuccessful');
    Route::get('/success', [PaymentController::class, 'paypalSuccess']);
    Route::get('/error', [PaymentController::class, 'paypalError']);
    Route::post('/pay', [PaymentController::class, 'donation'])->name('paypal-payment');
});

Route::get('/{any}', [SPAController::class, 'index'])->where('any', '.*');
