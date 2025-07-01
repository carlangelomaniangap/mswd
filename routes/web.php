<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPwdController;
use App\Http\Controllers\Admin\AdminAicsController;
use App\Http\Controllers\Admin\AdminAicsFamilyMemberController;
use App\Http\Controllers\Admin\AdminSeniorCitizenController;
use App\Http\Controllers\Admin\AdminSoloParentController;

use App\Http\Controllers\Pwd\PwdDashboardController;
use App\Http\Controllers\Pwd\PwdRecordsController;
use App\Http\Controllers\Pwd\PwdFamilyMemberController;

use App\Http\Controllers\Aics\AicsDashboardController;
use App\Http\Controllers\Aics\AicsRecordsController;
use App\Http\Controllers\Aics\AicsFamilyMemberController;


use App\Http\Controllers\Senior_Citizen\SeniorCitizenDashboardController;
use App\Http\Controllers\Senior_Citizen\SeniorCitizenRecordsController;

use App\Http\Controllers\Solo_Parent\SoloParentDashboardController;
use App\Http\Controllers\Solo_Parent\SoloParentRecordsController;

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

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/pwd', [AdminPwdController::class, 'index'])->name('pwd');
        Route::post('/pwd/store', [AdminPwdController::class,'store'])->name('store');
        Route::get('/pwd/data', [AdminPwdController::class, 'fetchData']);
        Route::get('/pwd/{id}', [AdminPwdController::class, 'getData']);
        Route::post('/pwd/{id}/update', [AdminPwdController::class,'update'])->name('update');

        Route::get('/aics', [AdminAicsController::class, 'index'])->name('aics');
        Route::post('/aics/store', [AdminAicsController::class,'store'])->name('store');
        Route::get('/aics/data', [AdminAicsController::class, 'fetchData']);
        Route::get('/aics/{id}', [AdminAicsController::class, 'getData']);
        Route::post('/aics/store/family-member', [AdminAicsFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/aics/{id}/family-member', [AdminAicsFamilyMemberController::class, 'getData']);

        Route::get('/senior_citizen', [AdminSeniorCitizenController::class, 'index'])->name('senior_citizen');
        Route::post('/senior_citizen/store', [AdminSeniorCitizenController::class,'store'])->name('store');
        Route::get('/senior_citizen/data', [AdminSeniorCitizenController::class, 'fetchData']);
        Route::get('/senior_citizen/{id}', [AdminSeniorCitizenController::class, 'getData']);

        Route::get('/solo_parent', [AdminSoloParentController::class, 'index'])->name('solo_parent');
        Route::post('/solo_parent/store', [AdminSoloParentController::class,'store'])->name('store');
        Route::get('/solo_parent/data', [AdminSoloParentController::class, 'fetchData']);
        Route::get('/solo_parent/{id}', [AdminSoloParentController::class, 'getData']);
});

Route::middleware(['auth', 'role:pwd'])
    ->prefix('pwd')
    ->as('pwd.')
    ->group(function () {
        Route::get('/dashboard', [PwdDashboardController::class, 'index'])->name('dashboard');
        Route::get('/records', [PwdRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [PwdRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [PwdRecordsController::class, 'fetchData']);
        Route::get('/records/{id}', [PwdRecordsController::class, 'getData']);
        Route::post('/records/{id}/update', [PwdRecordsController::class,'update'])->name('update');
});

Route::middleware(['auth', 'role:aics'])
    ->prefix('aics')
    ->as('aics.')
    ->group(function () {
        Route::get('/dashboard', [AicsDashboardController::class, 'index'])->name('dashboard');
        Route::get('/records', [AicsRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [AicsRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [AicsRecordsController::class, 'fetchData']);
        Route::get('/records/{id}', [AicsRecordsController::class, 'getData']);
        Route::post('/records/store/family-member', [AicsFamilyMemberController::class,'store'])->name('family_member_store');
        Route::get('/records/{id}/family-member', [AicsFamilyMemberController::class, 'getData']);

});

Route::middleware(['auth', 'role:senior_citizen'])
    ->prefix('senior_citizen')
    ->as('senior_citizen.')
    ->group(function () {
        Route::get('/dashboard', [SeniorCitizenDashboardController::class, 'index'])->name('dashboard');
        Route::get('/records', [SeniorCitizenRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [SeniorCitizenRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [SeniorCitizenRecordsController::class, 'fetchData']);
        Route::get('/records/{id}', [SeniorCitizenRecordsController::class, 'getData']);
});

Route::middleware(['auth', 'role:solo_parent'])
    ->prefix('solo_parent')
    ->as('solo_parent.')
    ->group(function () {
        Route::get('/dashboard', [SoloParentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/records', [SoloParentRecordsController::class, 'index'])->name('records');
        Route::post('/records/store', [SoloParentRecordsController::class,'store'])->name('store');
        Route::get('/records/data', [SoloParentRecordsController::class, 'fetchData']);
        Route::get('/records/{id}', [SoloParentRecordsController::class, 'getData']);
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
