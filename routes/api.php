<?php

use App\Http\Controllers\FamilyProfileController;
use App\Http\Controllers\HealthConditionController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::post('/addFamilyProfile', [FamilyProfileController::class, 'addFamilyProfile']);
    Route::post('/updateFamilyProfile', [FamilyProfileController::class, 'updateFamilyProfile']);
    Route::get('/showFamilyProfile', [FamilyProfileController::class, 'showFamilyProfile']);
    Route::delete('/destroyFamilyProfile', [FamilyProfileController::class, 'destroyFamilyProfile']);
});

Route::middleware('auth:sanctum')->group(function () {
    // ✅ للمستخدم العادي
    Route::get('/health-conditions/view-all', [HealthConditionController::class, 'viewAllConditions']);
    Route::post('/health-conditions/add', [HealthConditionController::class, 'addNewCondition']);
    Route::post('/family-profile/attach-conditions', [HealthConditionController::class, 'attachConditionToProfile']);
    Route::post('/family-profile/detach-conditions', [HealthConditionController::class, 'detachConditionFromProfile']);
    Route::get('/family-profile/view-my-condition', [HealthConditionController::class, 'getFamilyConditions']);
    // ✅ للأدمن فقط
    Route::middleware('is.admin')->group(function () {
        Route::post('/admin/health-conditions/{id}/approve', [HealthConditionController::class, 'approveCondition']);
    });
});
