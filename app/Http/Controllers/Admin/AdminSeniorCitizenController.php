<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeniorCitizenRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSeniorCitizenController extends Controller
{
    public function index()
    {
        return view('pages.admin.senior_citizen');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'house_no_unit_floor' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'barangay' => 'required|in:Bangkal,Calaylayan,Capitangan,Gabon,Laon,Mabatang,Omboy,Salian,Wawa',
            'city_municipality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'educational_attainment' => 'required|in:No Formal Education,Elementary Undergraduate,Elementary Graduate,High School Undergraduate,High School Graduate,Vocational Graduate,College Undergraduate,College Graduate,Post Graduate',
            'occupation' => 'required|string|max:255',
            'cellphone_number' => 'required|string|regex:/^09\d{9}$/',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            // Get the input photo
            $photo = $request->file('photo');

            // Get the original name of the photo
            $photoName = $photo->getClientOriginalName();

            // Move the uploaded file to the public/beneficiary_photos folder
            $photo->move(public_path('beneficiary_photos'), $photoName);

            // Store the photo's name in the database
            $photoPath = $photoName;
        }

        $user = Auth::user();

        SeniorCitizenRecord::create([
            'photo' => $photoPath,
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'house_no_unit_floor' => $validated['house_no_unit_floor'] ?? null,
            'street' => $validated['street'] ?? null,
            'barangay' => $validated['barangay'],
            'city_municipality' => $validated['city_municipality'],
            'province' => $validated['province'],
            'date_of_birth' => $validated['date_of_birth'],
            'place_of_birth' => $validated['place_of_birth'],
            'age' => $validated['age'],
            'sex' => $validated['sex'],
            'civil_status' => $validated['civil_status'],
            'educational_attainment' => $validated['educational_attainment'],
            'occupation' => $validated['occupation'],
            'cellphone_number' => $validated['cellphone_number'],
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Beneficiary added successfully.'
        ]);
    }

    public function fetchData()
    {
        $records = SeniorCitizenRecord::orderBy('id', 'asc')->get();

        $data = $records->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->last_name . ', ' . $record->first_name,
                'age' => $record->age,
                'address' => $record->barangay . ', ' . $record->city_municipality . ', ' . $record->province,
                'sex' => $record->sex,
                'cellphone_number' => $record->cellphone_number,
                'sc_id' => '<span class="text-sm text-white bg-blue-500 rounded-full px-2 py-1">AICS-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) . '</span>',
                'status' => '<span class="text-sm bg-yellow-300 text-yellow-700 rounded-full px-2 py-1">Expired</span>',
            ];
        });

        return response()->json(['data' => $data]);
    }
}