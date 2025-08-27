<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AicsFamilyMember;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAicsFamilyMemberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'aics_record_id' => 'required|exists:aics_records,id',
            'family_member_name' => 'required|string',
            'relationship' => 'required|string',
            'family_member_age' => 'required|numeric|min:0',
            'family_member_civil_status' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'family_member_educational_attainment' => 'required|in:No Formal Education,Elementary Undergraduate,Elementary Graduate,High School Undergraduate,High School Graduate,Vocational Graduate,College Undergraduate,College Graduate,Post Graduate',
            'family_member_occupation' => 'required|string|max:255',
            'family_member_monthly_income' => 'required|integer',
        ]);

        // Check if a family member with the same name, relationship, and age already exists
        $existing = AicsFamilyMember::where('family_member_name', $validated['family_member_name'])
            ->where('relationship', operator: $validated['relationship'])
            ->where('family_member_age', operator: $validated['family_member_age'])
            ->first();

        // If a family member is found, return an error response
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Family member already exists.',
            ]);
        }

        $user = Auth::user();

        AicsFamilyMember::create([
            'aics_record_id' => $validated['aics_record_id'],
            'family_member_name' => $validated['family_member_name'],
            'relationship' => $validated['relationship'],
            'family_member_age' => $validated['family_member_age'],
            'family_member_civil_status'=> $validated['family_member_civil_status'],
            'family_member_educational_attainment'=> $validated['family_member_educational_attainment'],
            'family_member_occupation'=> $validated['family_member_occupation'],
            'family_member_monthly_income'=> $validated['family_member_monthly_income'],
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Family member added successfully.'
        ]);
    }

    public function getData($id)
    {
        $data = AicsFamilyMember::where('aics_record_id',$id)->orderBy('id', 'desc')->get();
        return response()->json(['data' => $data]);
    }
}