<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeniorFamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSeniorFamilyMemberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sc_record_id' => 'required|exists:senior_citizen_records,id',
            'family_member_name' => 'required|string',
            'relationship' => 'required|string',
            'family_member_age' => 'required|numeric|min:0',
            'family_member_civil_status' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'family_member_occupation' => 'required|string|max:255',
            'family_member_monthly_income' => 'required|integer',
        ]);

        $user = Auth::user();

        SeniorFamilyMember::create([
            'sc_record_id' => $validated['sc_record_id'],
            'family_member_name' => $validated['family_member_name'],
            'relationship' => $validated['relationship'],
            'family_member_age' => $validated['family_member_age'],
            'family_member_civil_status'=> $validated['family_member_civil_status'],
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
        $data = SeniorFamilyMember::where('sc_record_id',$id)->orderBy('id', 'asc')->get();
        return response()->json(['data' => $data]);
    }
}