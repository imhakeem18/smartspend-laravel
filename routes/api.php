<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;

// Public authentication routes (no token required)
Route::post('/login', [AuthController::class, 'login']);

// Protected routes - require Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    
    // Get authenticated user info
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });
    
    // Token management routes
    Route::post('/tokens/generate', [AuthController::class, 'generateToken']);
    Route::get('/tokens', [AuthController::class, 'listTokens']);
    Route::delete('/tokens/revoke', [AuthController::class, 'revokeTokens']);
    Route::post('/logout', [AuthController::class, 'logout']);
    


    
    Route::apiResource('incomes', IncomeController::class);
    
    Route::apiResource('expenses', ExpenseController::class);

    Route::apiResource('categories', CategoryController::class);
    
});