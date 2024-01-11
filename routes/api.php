<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\DealerController;
use App\Http\Controllers\Api\EngineController;
use App\Http\Controllers\Api\ModelsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ManufacturerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Public APIs
Route::post('/login', [AuthController::class, 'login'])->name('user.login');
//register API
Route::post('/user', [UserController::class, 'store'])->name('user.store');

// Private APIs
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/all', [UserController::class, 'all']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    // Route::put('/user/image/{id}', [UserController::class, 'image'])->name('user.image');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    // Route::put('/user/name/{id}', [UserController::class, 'name'])->name('user.name');
    // Route::put('/user/email/{id}', [UserController::class, 'email'])->name('user.email');
    // Route::put('/user/password/{id}', [UserController::class, 'password'])->name('user.password');
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    //User Specific APIs = update of image based kong kinsa tong user nga ni log in
    Route::get('/profile/show', [ProfileController::class, 'show']);
    Route::put('/profile/image', [ProfileController::class, 'image'])->name('profile.image');

    Route::controller(ManufacturerController::class)->group(function () {
        Route::get('/manufacturer',               'index');
        Route::get('/manufacturer/{id}',          'show');
        Route::post('/manufacturer',              'store');
        Route::put('/manufacturer/{id}',          'update');
        Route::delete('/manufacturer/{id}',       'destroy');
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('/brand',               'index');
        Route::get('/brand/{id}',          'show');
        Route::post('/brand',              'store');
        Route::put('/brand/{id}',          'update');
        Route::delete('/brand/{id}',       'destroy');
    });

    Route::controller(ModelsController::class)->group(function () {
        Route::get('/model',               'index');
        Route::get('/model/{id}',          'show');
        Route::post('/model',              'store');
        Route::put('/model/{id}',          'update');
        Route::delete('/model/{id}',       'destroy');
    });

    Route::controller(VehicleController::class)->group(function () {
        Route::get('/vehicle',               'index');
        Route::get('/vehicle/all',               'all');
        Route::get('/vehicle/{id}',          'show');
        Route::post('/vehicle',              'store');
        Route::put('/vehicle/{id}',          'update');
        Route::delete('/vehicle/{id}',       'destroy');
    });

    Route::controller(EngineController::class)->group(function () {
        Route::get('/engine',               'index');
        Route::get('/engine/{id}',          'show');
        Route::post('/engine',              'store');
        Route::put('/engine/{id}',          'update');
        Route::delete('/engine/{id}',       'destroy');
    });

    Route::controller(DealerController::class)->group(function () {
        Route::get('/dealer',               'index');
        Route::get('/dealer/{id}',          'show');
        Route::post('/dealer',              'store');
        Route::put('/dealer/{id}',          'update');
        Route::delete('/dealer/{id}',       'destroy');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer',               'index');
        Route::get('/customer/{id}',          'show');
        Route::post('/customer',              'store');
        Route::put('/customer/{id}',          'update');
        Route::delete('/customer/{id}',       'destroy');
    });

    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier',               'index');
        Route::get('/supplier/{id}',          'show');
        Route::post('/supplier',              'store');
        Route::put('/supplier/{id}',          'update');
        Route::delete('/supplier/{id}',       'destroy');
    });
});
