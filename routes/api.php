<?php

use App\Http\Controllers\FamilyProfileController;
use App\Http\Controllers\HealthConditionController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\FridgeItemController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::post('/addFamilyProfile', [FamilyProfileController::class, 'addFamilyProfile']);
    Route::post('/updateFamilyProfile', [FamilyProfileController::class, 'updateFamilyProfile']);
    Route::get('/showFamilyProfile', [FamilyProfileController::class, 'showFamilyProfile']);
    Route::delete('/destroyFamilyProfile', [FamilyProfileController::class, 'destroyFamilyProfile']);
});

Route::middleware('auth:sanctum')->group(function () {
    //  للمستخدم العادي
    Route::get('/health-conditions/view-all', [HealthConditionController::class, 'viewAllConditions']);
    Route::post('/health-conditions/add', [HealthConditionController::class, 'addNewCondition']);
    Route::post('/family-profile/attach-conditions', [HealthConditionController::class, 'attachConditionToProfile']);
    Route::post('/family-profile/detach-conditions', [HealthConditionController::class, 'detachConditionFromProfile']);
    Route::get('/family-profile/view-my-condition', [HealthConditionController::class, 'getFamilyConditions']);
    //  للأدمن فقط
    Route::middleware('is.admin')->group(function () {
        Route::post('/admin/health-conditions/{id}/approve', [HealthConditionController::class, 'approveCondition']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    //  للمستخدم العادي
    Route::get('/ingredients/showallIng', [IngredientController::class, 'showallIng']);               // عرض كل المكونات
    Route::get('/ingredients/searchIng', [IngredientController::class, 'searchIng']);       // بحث عن مكون
    Route::get('/ingredients/showIng/{id}', [IngredientController::class, 'showIng']);           // عرض مكون محدد بالتفصيل
    Route::post('/ingredients/addIng', [IngredientController::class, 'addIng']);              // إضافة مكون جديد
    Route::post('/ingredient-aliases/addAlias', [IngredientController::class, 'addAlias']); // إضافة alias

    // Routes خاصة بالمدير (تحتاج صلاحيات admin)
    Route::middleware('is.admin')->group(function () {
        Route::post('/ingredients/updateIng/{id}', [IngredientController::class, 'updateIng']);     // تعديل مكون
        Route::delete('/ingredients/destroyIng/{id}', [IngredientController::class, 'destroyIng']); // حذف مكون

        // إدارة aliases
    });
});

Route::middleware('auth:sanctum')->group(function () {

    // عرض كل العناصر في الثلاجة
    Route::get('/fridge/ing-frid-all', [FridgeItemController::class, 'ingFridAll']);

    // إضافة عناصر للثلاجة
    Route::post('/fridge/add-ing-to-frid', [FridgeItemController::class, 'addIngToFrid']);

    // تعديل عنصر في الثلاجة
    Route::post('/fridge/update-frid/{id}', [FridgeItemController::class, 'updateFrid']);

    // حذف عنصر من الثلاجة
    Route::delete('/fridge/destroy-ing-for-frid/{id}', [FridgeItemController::class, 'destroyIngForFrid']);

    // تحديث توكن FCM
    Route::post('/update-fcm-token', [FridgeItemController::class, 'updateFcmToken']);

    //لكل يوزر يمكن فحص المكونات الخاصة به
    Route::get('/fridge/check-expirations-for-user', [FridgeItemController::class, 'checkExpirationsForUser']);

    // اختبار الإشعار (اختياري فقط للتجريب)
    Route::get('/fridge/check-expirations-for-all', [FridgeItemController::class, 'checkExpirationsForAll']);
});
