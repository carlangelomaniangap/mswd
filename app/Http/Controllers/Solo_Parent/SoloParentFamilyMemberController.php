<?php

namespace App\Http\Controllers\Solo_Parent;

use App\Http\Controllers\Controller;
use App\Models\SoloParentFamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloParentFamilyMemberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sp_record_id' => 'required|exists:solo_parent_records,id',
            'family_member_name' => 'required|string',
            'relationship' => 'required|string',
            'family_member_date_of_birth' => 'required|date',
            'family_member_age' => 'required|numeric|min:0',
            'family_member_sex' => 'required|in:Male,Female',
            'family_member_civil_status' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'family_member_educational_attainment' => 'required|in:No Formal Education,Elementary Undergraduate,Elementary Graduate,High School Undergraduate,High School Graduate,Vocational Graduate,College Undergraduate,College Graduate,Post Graduate',
            'family_member_occupation' => 'required|string|max:255',
            'family_member_monthly_income' => 'required|integer',
        ]);

        $user = Auth::user();

        SoloParentFamilyMember::create([
            'sp_record_id' => $validated['sp_record_id'],
            'family_member_name' => $validated['family_member_name'],
            'relationship' => $validated['relationship'],
            'family_member_date_of_birth'=> $validated['family_member_date_of_birth'],
            'family_member_age' => $validated['family_member_age'],
            'family_member_sex'=> $validated['family_member_sex'],
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
        $data = SoloParentFamilyMember::where('sp_record_id',$id)->orderBy('id', 'asc')->get();
        return response()->json(['data' => $data]);
    }
}