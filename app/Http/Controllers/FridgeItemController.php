<?php

namespace App\Http\Controllers;

use App\Models\FridgeItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\FirebaseService;
use App\Services\FridgeExpirationService;

class FridgeItemController extends Controller
{
    public function ingFridAll()
    {
        $profile_id = Auth()->user()->familyProfile->id;
        $items = FridgeItem::with('ingredient')
            ->where('family_profile_id', $profile_id)
            ->get();

        return response()->json($items);
    }

    public function addIngToFrid(Request $request)
    {
        $fridge = $request->validate([
            'items' => 'required|array',
            'items.*.ingredient_id' => 'required|exists:ingredients,id',
            'items.*.quantity' => 'required|string',
            'items.*.expiration_date' => 'nullable|date',
        ]);

        $profile_id = Auth()->user()->familyProfile->id;

        $createdItems = [];

        foreach ($request->items as $itemData) {
            $createdItems[] = FridgeItem::create([
                'family_profile_id' => $profile_id,
                'ingredient_id' => $itemData['ingredient_id'],
                'quantity' => $itemData['quantity'],
                'expiration_date' => $itemData['expiration_date'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'تمت إضافة العناصر بنجاح.',
            'data' => $createdItems,
        ], 201);
    }

    // تعديل عنصر في الثلاجة
    public function updateFrid(Request $request, $id)
    {
        $item = FridgeItem::where('id', $id)->where('family_profile_id', Auth()->user()->familyProfile->id)->firstOrFail();

        $request->validate([
            'quantity' => 'nullable|string',
            'expiration_date' => 'nullable|date',
        ]);

        $item->update($request->only(['quantity', 'expiration_date']));

        return response()->json($item);
    }

    // حذف عنصر من الثلاجة
    public function destroyIngForFrid($id)
    {
        $item = FridgeItem::where('id', $id)->where('family_profile_id', Auth()->user()->familyProfile->id)->firstOrFail();
        $item->delete();

        return response()->json(['message' => 'تم حذف العنصر من الثلاجة.']);
    }

    public function checkExpirationsForAll()
    {
        $expiringItems = (new FridgeExpirationService())->checkForAll();
        return response()->json([
            'message' => '✔️ تم فحص جميع المكونات.',
            'expiringItems' => $expiringItems
        ]);
    }

    public function checkExpirationsForUser()
    {
        $user = auth()->user();
        $expiringItems = (new FridgeExpirationService())->checkForFamily($user->familyProfile);

        return response()->json([
            'message' => '✔️ تم فحص مكوناتك.',
            'expiringItems' => $expiringItems,
        ]);
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'غير مصرح. المستخدم غير مسجل دخول.'], 401);
        }

        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json(['message' => 'تم تحديث رمز FCM بنجاح']);
    }

    //ارسال اشعار عبر تطبيق الجوال
    protected function notifyFamily($family, $message, $isExpired = false)
    {
        $firebase = new FirebaseService();

        foreach ($family->users as $user) {
            if ($user->fcm_token && $user->is_logged_in) {
                $title = $isExpired ? '⛔ منتج منتهي الصلاحية' : '📌 تنبيه صلاحية منتج';
                $firebase->sendNotification($user->fcm_token, $title, $message);
            }
        }
    }
}
