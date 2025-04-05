<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\ManageSuperAdminController;
use App\Http\Controllers\SuperAdmin\CompaniesController;
use App\Http\Controllers\SuperAdmin\insurancebenefitsController;
use App\Http\Controllers\SuperAdmin\CalenderController;
use App\Http\Controllers\SuperAdmin\KiborRatesController;
use App\Http\Controllers\SuperAdmin\PackagesController;
use App\Http\Controllers\SuperAdmin\RefundCustomerController;
use App\Http\Controllers\SuperAdmin\SlabsController;
use App\Http\Controllers\SuperAdmin\ActivePackageController;

use App\Http\Controllers\accounts\AccountAuthController;
use App\Http\Controllers\operations\operationsAuthController;
use App\Http\Controllers\investment\investmentAuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Super Admin
|--------------------------------------------------------------------------
|
*/

Route::prefix('super-admin')->group(function () {
    Route::get('/login', [SuperAdminAuthController::class, 'showLoginForm'])->name('superadmin.login');
    Route::post('/login', [SuperAdminAuthController::class, 'login'])->name('superadmin.loginform');

    Route::middleware(['auth:super_admin'])->group(function () {
        Route::get('/dashboard', [SuperAdminAuthController::class, 'showDashboard'])->name('superadmin.dashboard');
        Route::post('/logout', [SuperAdminAuthController::class, 'logout'])->name('superadmin.logout');
        Route::get('dashboard/counts', [SuperAdminAuthController::class, 'getCounts'])->name('dashboard.counts');

        Route::get('/index', [UserController::class, 'index'])->name('superadmin.index');
        Route::get('/create', [UserController::class, 'create'])->name('superadmin.create');
        Route::post('users/store', [UserController::class, 'store'])->name('superadmin.users.store');
        Route::get('users/edit/{planid}',[UserController::class,'edit'])->name('superadmin.users.edit');
        Route::post('users/update', [UserController::class, 'update'])->name('superadmin.users.update');


        Route::get('adminindex/index', [ManageSuperAdminController::class, 'index'])->name('superadmin.admincreate.index');
        Route::get('admincreate/create', [ManageSuperAdminController::class, 'create'])->name('superadmin.admincreate.create');
        Route::post('adminstore/store', [ManageSuperAdminController::class, 'store'])->name('superadmin.adminstore.stores');


        Route::get('compaines/index', [CompaniesController::class, 'index'])->name('superadmin.compaines.index');
        Route::get('compaines/create', [CompaniesController::class, 'create'])->name('superadmin.compaines.create');
        Route::post('compaines/store', [CompaniesController::class, 'store'])->name('superadmin.compaines.store');

        Route::get('insurancebenefits/index', [insurancebenefitsController::class, 'index'])->name('superadmin.insurancebenefits.index');
        Route::get('insurancebenefits/create', [insurancebenefitsController::class, 'create'])->name('superadmin.insurancebenefits.create');
        Route::post('insurancebenefits/store', [insurancebenefitsController::class, 'store'])->name('superadmin.insurancebenefits.store');

        Route::get('KiborRates/index', [KiborRatesController::class, 'index'])->name('superadmin.KiborRates.index');
        Route::get('KiborRates/create', [KiborRatesController::class, 'create'])->name('superadmin.KiborRates.create');
        Route::post('KiborRates/store', [KiborRatesController::class, 'store'])->name('superadmin.KiborRates.store');

        Route::get('Packages/index', [PackagesController::class, 'index'])->name('superadmin.Packages.index');
        Route::get('Packages/create', [PackagesController::class, 'create'])->name('superadmin.Packages.create');
        Route::post('Packages/store', [PackagesController::class, 'store'])->name('superadmin.Packages.store');

        Route::get('RefundCustomer/index', [RefundCustomerController::class, 'index'])->name('superadmin.RefundCustomer.index');
        Route::get('RefundCustomer/create', [RefundCustomerController::class, 'create'])->name('superadmin.RefundCustomer.create');
        Route::post('RefundCustomer/store', [RefundCustomerController::class, 'store'])->name('superadmin.RefundCustomer.store');

        Route::get('Slabs/index', [SlabsController::class, 'index'])->name('superadmin.Slabs.index');
        Route::get('Slabs/create', [SlabsController::class, 'create'])->name('superadmin.Slabs.create');
        Route::post('Slabs/store', [SlabsController::class, 'store'])->name('superadmin.Slabs.store');

        Route::get('Calender/index', [CalenderController::class, 'index'])->name('superadmin.Calender.index');
        Route::get('Calender/create', [CalenderController::class, 'create'])->name('superadmin.Calender.create');
        Route::post('Calender/store', [CalenderController::class, 'store'])->name('superadmin.Calender.store');


        Route::get('active/Packages/index', [ActivePackageController::class, 'index'])->name('superadmin.active.Packages.index');
        Route::get('active/Packages/show/{id}', [ActivePackageController::class, 'show'])->name('superadmin.active.Packages.show');



    });
});

/*
|--------------------------------------------------------------------------
| Accounts
|--------------------------------------------------------------------------
|
*/
Route::prefix('accounts')->group(function () {
    Route::get('/login', [AccountAuthController::class, 'showLoginForm'])->name('accounts.login');
    Route::post('/login', [AccountAuthController::class, 'login'])->name('accounts.loginform');

    Route::middleware(['web', 'accounts'])->group(function () {
        Route::get('/dashboard', [AccountAuthController::class, 'showDashboard'])->name('accounts.dashboards');
        Route::post('/logout', [AccountAuthController::class, 'logout'])->name('accounts.logout');

    });
});

/*
|--------------------------------------------------------------------------
|Investments
|--------------------------------------------------------------------------
|
*/

Route::prefix('investment')->group(function () {
    Route::get('/login', [investmentAuthController::class, 'showLoginForm'])->name('investment.login');
    Route::post('/login', [investmentAuthController::class, 'login'])->name('investment.loginform');

    Route::middleware(['web', 'investment'])->group(function () {
        Route::get('/dashboard', [investmentAuthController::class, 'showDashboard'])->name('investment.dashboards');
        Route::post('/logout', [investmentAuthController::class, 'logout'])->name('investment.logout');

    });
});

/*
|--------------------------------------------------------------------------
| Operations
|--------------------------------------------------------------------------
|
*/

Route::prefix('operations')->group(function () {
    Route::get('/login', [operationsAuthController::class, 'showLoginForm'])->name('operations.login');
    Route::post('/login', [operationsAuthController::class, 'login'])->name('operations.loginform');

    Route::middleware(['web', 'operations'])->group(function () {
        Route::get('/dashboard', [operationsAuthController::class, 'showDashboard'])->name('operations.dashboards');
        Route::post('/logout', [operationsAuthController::class, 'logout'])->name('operations.logout');

    });
});



/*
|--------------------------------------------------------------------------
|Other Routes
|--------------------------------------------------------------------------
|
*/

  Route::get('/', function (Request $request) {

      return view('welcome');
  });

// Cache Routes
