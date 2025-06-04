<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminStatistics;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-role', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'roles' => $request->user()->getRoleNames(),
        ]);
    })->name('user.role');
    Route::get('/admin/statistics', [AdminStatistics::class, 'statistics']);
    Route::get('/branch-statistics/{branchId}', [AdminStatistics::class, 'branchStatistics']);
    Route::get('/store-statistics/{storeId}', [AdminStatistics::class, 'storeStatistics']);

    // Branch CRUD
    Route::post('/create-branch', [BranchController::class, 'create']);
    Route::get('/branches', [BranchController::class, 'index']);
    Route::post('/edit-branch/{id}', [BranchController::class, 'update']);
    Route::delete('/delete-branch/{id}', [BranchController::class, 'destroy']);

    // Store CRUD
    Route::post('/create-store', [StoreController::class, 'create']);
    Route::get('/stores', [StoreController::class, 'index']);
    Route::post('/edit-store/{id}', [StoreController::class, 'update']);
    Route::delete('/delete-store/{id}', [StoreController::class, 'destroy']);

    // Product CRUD
    Route::post('/create-product', [ProductsController::class, 'create']);
    Route::get('/products', [ProductsController::class, 'index']);
    Route::post('/edit-product/{id}', [ProductsController::class, 'update']);
    Route::delete('/delete-product/{id}', [ProductsController::class, 'destroy']);

    // Stock CRUD
    Route::post('/create-inventory', [StockController::class, 'create']);
    Route::get('/inventories', [StockController::class, 'index']);
    Route::post('/edit-inventory/{id}', [StockController::class, 'update']);
    Route::delete('/delete-inventory/{id}', [StockController::class, 'destroy']);

    // Sales CRUD
    Route::post('/create-sale', [SaleController::class, 'create']);
    Route::get('/sales', [SaleController::class, 'index']);
    Route::post('/edit-sale/{id}', [SaleController::class, 'update']);
    Route::delete('/delete-sale/{id}', [SaleController::class, 'destroy']);

    // Transfer CRUD
    Route::post('/create-transfer', [TransferController::class, 'create']);
    Route::get('/transfers', [TransferController::class, 'index']);
    Route::post('/edit-transfer/{id}', [TransferController::class, 'update']);
    Route::delete('/delete-transfer/{id}', [TransferController::class, 'destroy']);

    // User Role Management
    Route::post('/register-tenant-admin', [RegisteredUserController::class, 'addAdmin']);
    Route::get('/users', [AdminController::class, 'index']);
    Route::post('/edit-admin/{id}', [AdminController::class, 'update']);

    // Roles
    Route::post('/create-position', [RoleController::class, 'create']);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/edit-position/{id}', [RoleController::class, 'update']);
    Route::delete('/delete-position/{id}', [RoleController::class, 'destroy']);


});
