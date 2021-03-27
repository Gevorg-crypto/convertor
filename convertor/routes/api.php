<?php

use App\Http\Controllers\Api\V1\BankOfRassiaController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::get('/currencies', [BankOfRassiaController::class, 'getCurrency']);
    Route::post('/convert ', [BankOfRassiaController::class, 'postConvert']);
});
