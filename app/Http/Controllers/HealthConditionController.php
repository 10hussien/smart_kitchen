<?php

namespace App\Http\Controllers;

use App\Models\HealthCondition;
use App\Models\FamilyProfile;
use Illuminate\Http\Request;

class HealthConditionController extends Controller
{
    // View all approved conditions
    public function viewAllConditions()
    {
        return HealthCondition::where('is_approved', true)->get();
    }

    public function addNewCondition(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:health_conditions,name',
        ]);

        $condition = HealthCondition::create([
            'name' => $request->name,
            'is_approved' => false,
        ]);

        return response()->json(['message' => 'add submitted. Pending admin approval.', 'condition' => $condition], 201);
    }

    // Admin approves condition
    public function approveCondition($id)
    {
        $condition = HealthCondition::findOrFail($id);

        $condition->update(['is_approved' => true]);

        return response()->json(['message' => 'Condition approved.']);
    }

    // Attach condition to family profile
    public function attachConditionToProfile(Request $request)
    {
        $request->validate([
            'health_condition_ids' => 'required|array|min:1',
            'health_condition_ids.*' => 'exists:health_conditions,id',
        ]);

        $profile = auth()->user()->familyProfile;

        if (!$profile) {
            return response()->json(['error' => 'No family profile found for this user'], 404);
        }

        $profile->healthConditions()->syncWithoutDetaching($request->health_condition_ids);

        return response()->json(['message' => 'Conditions attached successfully.']);
    }

    public function detachConditionFromProfile(Request $request)
    {
        $request->validate([
            'health_condition_ids' => 'required|array|min:1',
            'health_condition_ids.*' => 'exists:health_conditions,id',
        ]);

        $profile = auth()->user()->familyProfile;

        if (!$profile) {
            return response()->json(['error' => 'No family profile found for this user'], 404);
        }

        $profile->healthConditions()->detach($request->health_condition_ids);

        return response()->json(['message' => 'Conditions detached successfully.']);
    }

    public function getFamilyConditions()
    {
        $profileId = auth()->user()->familyProfile->id;
        $profile = FamilyProfile::with('healthConditions')->findOrFail($profileId);
        return response()->json($profile->healthConditions);
    }
}
