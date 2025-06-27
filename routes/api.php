<?php

use App\Http\Controllers\FamilyProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::post('/addFamilyProfile', [FamilyProfileController::class, 'addFamilyProfile']);
    Route::post('/updateFamilyProfile', [FamilyProfileController::class, 'updateFamilyProfile']);
    Route::get('/showFamilyProfile', [FamilyProfileController::class, 'showFamilyProfile']);
    Route::delete('/destroyFamilyProfile', [FamilyProfileController::class, 'destroyFamilyProfile']);
});
