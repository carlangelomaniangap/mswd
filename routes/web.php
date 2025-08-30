<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AicsQRScannerController;
use App\Http\Controllers\PwdQRScannerController;
use App\Http\Controllers\SeniorQRScannerController;
use App\Http\Controllers\SoloParentQRScannerController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPwdController;
use App\Http\Controllers\Admin\AdminPwdRequirementsController;
use App\Http\Controllers\Admin\AdminAicsController;
use App\Http\Controllers\Admin\AdminAicsRequirementsController;
use App\Http\Controllers\Admin\AdminAicsFamilyMemberController;
use App\Http\Controllers\Admin\AdminAicsPayoutController;
use App\Http\Controllers\Admin\AdminSeniorCitizenController;
use App\Http\Controllers\Admin\AdminSeniorFamilyMemberController;
use App\Http\Controllers\Admin\AdminSeniorRequirementsController;
use App\Http\Controllers\Admin\AdminSoloParentController;
use App\Http\Controllers\Admin\AdminSoloParentFamilyMemberController;
use App\Http\Controllers\Admin\AdminSoloParentRequirementsController;
use App\Http\Controllers\Admin\AdminManageAccountController;

use App\Http\Controllers\Pwd\PwdDashboardController;
use App\Http\Controllers\Pwd\PwdRecordsController;
use App\Http\Controllers\Pwd\PwdRequirementsController;

use App\Http\Controllers\Aics\AicsDashboardController;
use App\Http\Controllers\Aics\AicsRecordsController;
use App\Http\Controllers\Aics\AicsRequirementsController;
use App\Http\Controllers\Aics\AicsFamilyMemberController;
use App\Http\Controllers\Aics\AicsPayoutController;

use App\Http\Controllers\Senior_Citizen\SeniorCitizenDashboardController;
use App\Http\Controllers\Senior_Citizen\SeniorCitizenRecordsController;
use App\Http\Controllers\Senior_Citizen\SeniorFamilyMemberController;
use App\Http\Controllers\Senior_Citizen\SeniorRequirementsController;

use App\Http\Controllers\Solo_Parent\SoloParentDashboardController;
use App\Http\Controllers\Solo_Parent\SoloParentRecordsController;
use App\Http\Controllers\Solo_Parent\SoloParentFamilyMemberController;
use App\Http\Controllers\Solo_Parent\SoloParentRequirementsController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'role:admin,aics'])->group(function () {
    Route::get('/aics/record/data/scan', [AicsQRScannerController::class, 'index'])->name('qrcode_scanner');
    Route::get('/aics/record/data/scan/{id}', [AicsQRScannerController::class, 'scan']);
});

Route::middleware(['auth', 'role:admin,pwd'])->group(function () {
    Route::get('/pwd/record/data/scan', [PwdQRScannerController::class, 'index'])->name('qrcode_scanner');
    Route::get('/pwd/record/data/scan/{id}', [PwdQRScannerController::class, 'scan']);
});

Route::middleware(['auth', 'role:admin,senior_citizen'])->group(function () {
    Route::get('/senior_citizen/record/data/scan', [SeniorQRScannerController::class, 'index'])->name('qrcode_scanner');
    Route::get('/senior_citizen/record/data/scan/{id}', [SeniorQRScannerController::class, 'scan']);
});

Route::middleware(['auth', 'role:admin,solo_parent'])->group(function () {
    Route::get('/solo_parent/record/data/scan', [SoloParentQRScannerController::class, 'index'])->name('qrcode_scanner');
    Route::get('/solo_parent/record/data/scan/{id}', [SoloParentQRScannerController::class, 'scan']);
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/fetch', [AdminDashboardController::class, 'fetch']);

        Route::get('/pwd', [AdminPwdController::class, 'index'])->name('pwd');
        Route::post('/pwd/store', [AdminPwdController::class,'store'])->name('store');
        Route::get('/pwd/data', [AdminPwdController::class, 'fetchData']);
        Route::post('/pwd/{id}/update', [AdminPwdController::class,'update'])->name('update');
        Route::post('/pwd/{id}/update/requirements', [AdminPwdRequirementsController::class, 'update']);

        Route::get('/aics', [AdminAicsController::class, 'index'])->name('aics');
        Route::post('/aics/store', [AdminAicsController::class,'store'])->name('store');
        Route::get('/aics/data', [AdminAicsController::class, 'fetchData']);
        Route::post('/aics/{id}/update/requirements', [AdminAicsRequirementsController::class, 'update']);
        Route::post('/aics/store/family-member', [AdminAicsFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/aics/{id}/family-member', [AdminAicsFamilyMemberController::class, 'getData']);
        Route::post('/aics/store/payout', [AdminAicsPayoutController::class,'store']);
        Route::get('/aics/{id}/payout-histories', [AdminAicsPayoutController::class, 'getData']);

        Route::get('/senior_citizen', [AdminSeniorCitizenController::class, 'index'])->name('senior_citizen');
        Route::post('/senior_citizen/store', [AdminSeniorCitizenController::class,'store'])->name('store');
        Route::get('/senior_citizen/data', [AdminSeniorCitizenController::class, 'fetchData']);
        Route::post('/senior_citizen/store/family-member', [AdminSeniorFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/senior_citizen/{id}/family-member', [AdminSeniorFamilyMemberController::class, 'getData']);
        Route::post('/senior_citizen/{id}/update/requirements', [AdminSeniorRequirementsController::class, 'update']);

        Route::get('/solo_parent', [AdminSoloParentController::class, 'index'])->name('solo_parent');
        Route::post('/solo_parent/store', [AdminSoloParentController::class,'store'])->name('store');
        Route::get('/solo_parent/data', [AdminSoloParentController::class, 'fetchData']);
        Route::post('/solo_parent/store/family-member', [AdminSoloParentFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/solo_parent/{id}/family-member', [AdminSoloParentFamilyMemberController::class, 'getData']);
        Route::post('/solo_parent/{id}/update/requirements', [AdminSoloParentRequirementsController::class, 'update']);

        Route::get('/manage_account', [AdminManageAccountController::class, 'index'])->name('manage_account');
        Route::get('/manage_account/data', [AdminManageAccountController::class, 'fetchData']);
        Route::post('/manage_account/{id}/update', [AdminManageAccountController::class, 'update']);
});

Route::middleware(['auth', 'role:pwd'])
    ->prefix('pwd')
    ->as('pwd.')
    ->group(function () {
        Route::get('/dashboard', [PwdDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/fetch', [PwdDashboardController::class, 'fetch']);
        Route::get('/records', [PwdRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [PwdRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [PwdRecordsController::class, 'fetchData']);
        Route::post('/records/{id}/update', [PwdRecordsController::class,'update'])->name('update');
        Route::post('/records/{id}/update/requirements', [PwdRequirementsController::class, 'update']);
});

Route::middleware(['auth', 'role:aics'])
    ->prefix('aics')
    ->as('aics.')
    ->group(function () {
        Route::get('/dashboard', [AicsDashboardController::class, 'index'])->name('dashboard');
        Route::get('/records', [AicsRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [AicsRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [AicsRecordsController::class, 'fetchData']);
        Route::post('/records/{id}/update/requirements', [AicsRequirementsController::class, 'update']);
        Route::post('/records/store/family-member', [AicsFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/records/{id}/family-member', [AicsFamilyMemberController::class, 'getData']);
        Route::post('/records/store/payout', [AicsPayoutController::class,'store']);
        Route::get('/records/{id}/payout-histories', [AicsPayoutController::class, 'getData']);
});

Route::middleware(['auth', 'role:senior_citizen'])
    ->prefix('senior_citizen')
    ->as('senior_citizen.')
    ->group(function () {
        Route::get('/dashboard', [SeniorCitizenDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/fetch', [SeniorCitizenDashboardController::class, 'fetch']);
        Route::get('/records', [SeniorCitizenRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [SeniorCitizenRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [SeniorCitizenRecordsController::class, 'fetchData']);
        Route::post('/records/store/family-member', [SeniorFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/records/{id}/family-member', [SeniorFamilyMemberController::class, 'getData']);
        Route::post('/records/{id}/update/requirements', [SeniorRequirementsController::class, 'update']);
});

Route::middleware(['auth', 'role:solo_parent'])
    ->prefix('solo_parent')
    ->as('solo_parent.')
    ->group(function () {
        Route::get('/dashboard', [SoloParentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/fetch', [SoloParentDashboardController::class, 'fetch']);
        Route::get('/records', [SoloParentRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [SoloParentRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [SoloParentRecordsController::class, 'fetchData']);
        Route::post('/records/store/family-member', [SoloParentFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/records/{id}/family-member', [SoloParentFamilyMemberController::class, 'getData']);
        Route::post('/records/{id}/update/requirements', [SoloParentRequirementsController::class, 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
