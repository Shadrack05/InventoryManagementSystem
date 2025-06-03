<?php

use App\Http\Controllers\AdminStatistics;
use App\Http\Controllers\BranchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

});
