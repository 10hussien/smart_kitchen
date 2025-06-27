<?php

use App\Models\FamilyProfile;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::post('/addProfile', [FamilyProfile::class, 'addProfile']);
    Route::post('/updateProfile', [FamilyProfile::class, 'updateProfile']);
    Route::get('/showProfile', [FamilyProfile::class, 'showProfile']);
    Route::delete('/destroyProfile', [FamilyProfile::class, 'destroyProfile']);
});
