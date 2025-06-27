<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyProfileRequest;
use App\Models\FamilyProfile;
use Illuminate\Http\Request;

class FamilyProfileController extends Controller
{

    public function addProfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'number_of_people' => 'required|integer|min:1',
        ]);

        $profile = FamilyProfile::create($request->all());

        return response()->json($profile, 201);
    }

    public function showProfile()
    {
        $profile = FamilyProfile::where('user_id', auth()->id())->first();
        return response()->json($profile);
    }


    public function updateProfile(FamilyProfileRequest $request)
    {
        $user = auth()->user();
        $familyProfile = $user->familyProfile;

        $familyProfile->update($request->all());
        return $familyProfile;
    }


    public function destroyProfile()
    {
        $user = auth()->user();
        $familyProfile = $user->familyProfile;
        $familyProfile->delete();
        return response()->json(null, 204);
    }
}
