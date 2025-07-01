<?php

namespace App\Services;

use App\Models\FridgeItem;
use Carbon\Carbon;
use App\Services\FirebaseService;

class FridgeExpirationService
{
    public function checkForAll()
    {
        $items = FridgeItem::with(['ingredient', 'familyProfile.user'])->get();
        return $this->checkItems($items);
    }

    public function checkForFamily($familyProfile)
    {
        $items = FridgeItem::with('ingredient')
            ->where('family_profile_id', $familyProfile->id)
            ->get();

        return $this->checkItems($items);
    }

    protected function checkItems($items)
    {
        $today = Carbon::today();
        $firebase = new FirebaseService();
        $expiringItems = [];

        foreach ($items as $item) {
            if (!$item->expiration_date) continue;

            $exp = Carbon::parse($item->expiration_date);
            $daysLeft = $today->diffInDays($exp, false);
            $ingredientName = $item->ingredient->name;
            $family = $item->familyProfile;
            $user = $family->user;

            if (!$user || !$user->fcm_token) continue;

            if ($daysLeft < 0) {
                $notificationMessage = "❌ انتهت صلاحية المنتج [$ingredientName]، يرجى التخلص منه.";
                $firebase->sendNotification(
                    $user->fcm_token,
                    '⛔ منتج منتهي الصلاحية',
                    $notificationMessage
                );
                $expiringItems[] = [
                    'ingredient' => $ingredientName,
                    'expiration_date' => $exp->toDateString(),
                    'days_left' => $daysLeft,
                    'notification_message' => $notificationMessage,
                ];
                $item->delete();
            } elseif ($daysLeft <= 5) {
                $notificationMessage = "⚠️ المنتج [$ingredientName] ينتهي بعد $daysLeft يوم بتاريخ [" . $exp->toDateString() . "]، يُفضل استخدامه قريبًا.";

                $expiringItems[] = [
                    'ingredient' => $ingredientName,
                    'expiration_date' => $exp->toDateString(),
                    'days_left' => $daysLeft,
                    'notification_message' => $notificationMessage,
                ];

                $firebase->sendNotification(
                    $user->fcm_token,
                    '📌 تنبيه صلاحية منتج',
                    $notificationMessage
                );
            }
        }

        return $expiringItems;
    }

    // تجميع الرسائل ممع بعض
    // protected function checkItems($items)
    // {
    //     $today = Carbon::today();
    //     $firebase = new FirebaseService();

    //     // مصفوفة لجمع التنبيهات لكل مستخدم
    //     $userNotifications = [];
    //     // مصفوفة لترجيع تفاصيل كل مكون (كما طلبت)
    //     $expiringItems = [];

    //     foreach ($items as $item) {
    //         if (!$item->expiration_date) continue;

    //         $exp = Carbon::parse($item->expiration_date);
    //         $daysLeft = $today->diffInDays($exp, false);
    //         $ingredientName = $item->ingredient->name;
    //         $family = $item->familyProfile;
    //         $user = $family->user;

    //         if (!$user || !$user->fcm_token) continue;

    //         if ($daysLeft < 0) {
    //             $notificationMessage = "❌ انتهت صلاحية المنتج [$ingredientName]، يرجى التخلص منه.";
    //             // حذف المنتج من قاعدة البيانات
    //             $item->delete();
    //         } elseif ($daysLeft <= 5) {
    //             $notificationMessage = "⚠️ المنتج [$ingredientName] ينتهي بعد $daysLeft يوم بتاريخ [" . $exp->toDateString() . "]، يُفضل استخدامه قريبًا.";
    //         } else {
    //             // إذا المنتج لم ينتهِ ولم يكن قريب من الانتهاء، نتخطاه
    //             continue;
    //         }

    //         // نجمع إشعارات المستخدم مع بعض (نجمع الرسائل)
    //         if (!isset($userNotifications[$user->fcm_token])) {
    //             $userNotifications[$user->fcm_token] = [];
    //         }
    //         $userNotifications[$user->fcm_token][] = $notificationMessage;

    //         // نضيف التفاصيل لمصفوفة الرد
    //         $expiringItems[] = [
    //             'ingredient' => $ingredientName,
    //             'expiration_date' => $exp->toDateString(),
    //             'days_left' => $daysLeft,
    //             'notification_message' => $notificationMessage,
    //         ];
    //     }

    //     // بعد انتهاء الفحص، نرسل إشعار واحد لكل مستخدم يحتوي على جميع التنبيهات
    //     foreach ($userNotifications as $fcmToken => $messages) {
    //         $title = 'تنبيهات صلاحية منتجاتك';
    //         $body = implode("\n", $messages); // نجمع الرسائل مع سطر جديد بين كل رسالة
    //         $firebase->sendNotification($fcmToken, $title, $body);
    //     }

    //     return $expiringItems;
    // }
}
