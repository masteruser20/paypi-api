<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('ping', function () {
    return response()->json([
        'ack' => time()
    ]);
});

Route::get('methods', function () {
    $methods = Cache::remember('payment_methods', '60', function () {
        return new \App\Http\Resources\PaymentProvidersCollection(\App\PaymentProvider::all());
    });

    return response()->json(
        $methods
    );
});

Route::resource('transactions', 'TransactionController');
