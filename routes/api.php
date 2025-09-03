<?php
use App\Http\Controllers\{
    AuthController,
    FarmerController,
    CropController,
    DashboardController,
    ProfileController
};

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);

    // Profile Management (for any logged in user)
    Route::get('/profile', [ProfileController::class,'show']);
    Route::put('/profile', [ProfileController::class,'update']);

    // Dashboards
    Route::get('/dashboard/admin', [DashboardController::class,'admin'])->middleware('role:admin');
    Route::get('/dashboard/farmer',[DashboardController::class,'farmer'])->middleware('role:farmer');

    // Farmers (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/farmers', [FarmerController::class,'index']);
        Route::post('/farmers', [FarmerController::class,'store']);
        Route::get('/farmers/{user}', [FarmerController::class,'show']);
        Route::put('/farmers/{user}', [FarmerController::class,'update']);
        Route::delete('/farmers/{user}', [FarmerController::class,'destroy']);
    });

    // Crops (Admin sees all; Farmer only own enforced in controller)
    Route::get('/crops', [CropController::class,'index']);
    Route::post('/crops', [CropController::class,'store']);
    Route::put('/crops/{crop}', [CropController::class,'update']);
    Route::delete('/crops/{crop}', [CropController::class,'destroy']);
});
