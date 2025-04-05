<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SlabsController;
use App\Http\Controllers\EasypaisaController;
use App\Http\Controllers\API\SavingController;
use App\Http\Controllers\API\InsuranceDataController;
use App\Http\Controllers\BeneficiaryController;



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
Route::post('/easypaisa/createPayment', [EasypaisaController::class, 'createPayment'])->name('easypaisa.createPayment');
Route::post('/easypaisa/daily-profit', [EasypaisaController::class, 'getDailyReturns'])->name('easypaisa.getDailyReturns');


//Order Create Start Saving API 
// Withdrawal API 
// Add Funds API 

//Payment Ky Baad Order Start Saving Hogi and Then Daily Profit Calculate hoga.

Route::post('/eful/start-saving', [SavingController::class, 'startSaving'])->name('easypaisa.startSaving');
Route::post('/eful/add-funds', [SavingController::class, 'addFunds'])->name('easypaisa.addFunds');
Route::post('/eful/withdraw', [SavingController::class, 'withdraw'])->name('easypaisa.withdraw');
Route::post('/eful/payment-confirmed', [SavingController::class, 'handlePaymentResponse'])->name('easypaisa.handlePaymentResponse');
Route::post('/eful/add-beneficiary', [BeneficiaryController::class, 'store']);


Route::post('/eful/add-funds', [SavingController::class, 'addFunds'])->name('easypaisa.addFunds');
Route::post('/eful/confirm-add-funds', [SavingController::class, 'confirmAddFunds'])->name('easypaisa.confirmAddFunds');




//Insurance API,
Route::post('eful/update-active-policy', [InsuranceDataController::class, 'updateActivePolicy']);

