<?php

namespace App\Http\Controllers\Aics;

use App\Http\Controllers\Controller;
use App\Models\AicsFamilyMember;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AicsFamilyMemberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'aics_record_id' => 'required|exists:aics_records,id',
            'family_member_name' => 'required|string',
            'relationship' => 'required|in:Great-grandfather,Great-grandmother,Great-grandson,Great-granddaughter,
                GrandFather,GrandMother,Grandson,Granddaughter,
                Father,Mother,Spouse,Uncle,Auntie,Brother,Sister,
                Son,Daughter,Nephew,Niece,Cousin,
                Father-in-law,Mother-in-law,Brother-in-law,Sister-in-law,
                Son-in-law,Daughter-in-law,
                Stepfather,Stepmother,Stepbrother,Stepsister,
                Half-brother,Half-sister',
            'family_member_age' => 'required|numeric|min:0',
            'family_member_status' => 'required|string',
        ]);

        $user = Auth::user();

        AicsFamilyMember::create([
            'aics_record_id' => $validated['aics_record_id'],
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
        $data = AicsFamilyMember::where('aics_record_id',$id)->orderBy('id', 'asc')->get();
        return response()->json(['data' => $data]);
    }
}