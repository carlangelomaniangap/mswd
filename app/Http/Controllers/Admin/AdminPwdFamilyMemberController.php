<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PwdFamilyMember;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPwdFamilyMemberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pwd_record_id' => 'required|exists:pwd_records,id',
            'family_member_name' => 'required|string',
            'relationship' => 'required|string',
            'family_member_age' => 'required|numeric|min:0',
            'family_member_status' => 'required|string',
        ]);

        $user = Auth::user();

        PwdFamilyMember::create([
            'pwd_record_id' => $validated['pwd_record_id'],
            'family_member_name' => $validated['family_member_name'],
            'relationship' => $validated['relationship'],
            'family_member_age' => $validated['family_member_age'],
            'family_member_status' => $validated['family_member_status'],
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
        $data = PwdFamilyMember::where('pwd_record_id',$id)->orderBy('id', 'asc')->get();
        return response()->json(['data' => $data]);
    }
}