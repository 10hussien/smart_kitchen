<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyProfileRequest;
use App\Models\FamilyProfile;
use Illuminate\Http\Request;

class FamilyProfileController extends Controller
{

    public function addFamilyProfile(Request $request)
    {
        $request->validate([
            'number_of_people' => 'required|string|min:1',
        ]);

        $profile = FamilyProfile::create([
            'user_id' => auth()->id(),
            'number_of_people' => $request->number_of_people
        ]);
        return response()->json($profile, 201);
    }

    public function showFamilyProfile()
    {
        $profile = FamilyProfile::where('user_id', auth()->id())->first();
        return response()->json($profile);
    }


    public function updateFamilyProfile(FamilyProfileRequest $request)
    {
        $user = auth()->user();
        $familyProfile = $user->familyProfile;
        if (!$familyProfile) {
            return response()->json(['error' => 'Family profile not found.'], 404);
        }


        $familyProfile->update($request->all());
        return $familyProfile;
    }


    public function destroyFamilyProfile()
    {
        $user = auth()->user();
        $familyProfile = $user->familyProfile;
        $familyProfile->delete();
        return response()->json(null, 204);
    }
}
