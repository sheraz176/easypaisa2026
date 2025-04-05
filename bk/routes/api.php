<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SlabsController;
use App\Http\Controllers\EasypaisaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('Slabs/V001/Api', [SlabsController::class, 'SlabsApi'])->name('Api.Slabs.SlabsApi');

Route::get('/easypaisa/apply/token', [EasypaisaController::class, 'applyToken'])->name('Api.easypaisa.token');;
Route::post('/easypaisa/check/openid', [EasypaisaController::class, 'checkOpenId'])->name('easypaisa.checkOpenId');
Route::post('/easypaisa/auth-code', [EasypaisaController::class, 'getAuthCode'])->name('easypaisa.authCode');
