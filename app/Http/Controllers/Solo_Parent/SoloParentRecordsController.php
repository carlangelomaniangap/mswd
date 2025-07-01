<?php

namespace App\Http\Controllers\Solo_Parent;

use App\Http\Controllers\Controller;
use App\Models\SoloParentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SoloParentRecordsController extends Controller
{
    public function index()
    {
        return view('pages.solo_parent.records');
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
            'religion' => 'required|string|max:255',
            'philsys_card_number' => 'required|integer',
            'educational_attainment' => 'required|in:No Formal Education,Elementary Undergraduate,Elementary Graduate,High School Undergraduate,High School Graduate,Vocational Graduate,College Undergraduate,College Graduate,Post Graduate',
            'employment_status' => 'required|string|in:Employed,Unemployed,Self-Employed,Retired',
            'occupation' => 'required|string|max:255',
            'company_agency' => 'required|string|max:255',
            'monthly_income' => 'required|integer',
            'cellphone_number' => 'required|string|regex:/^09\d{9}$/',
            'number_of_children'=> 'required|integer',
            'pantawid_beneficiary' => 'required|string|in:Yes,No',
            'household_id' => 'required_if:pantawid_beneficiary,Yes|nullable|string|max:255',
            'indigenous_person' => 'required|string|in:Yes,No',
            'name_of_affliation' => 'required_if:indigenous_person,Yes|nullable|string|max:255',
            'emerg_first_name' => 'required|string|max:255',
            'emerg_middle_name' => 'nullable|string|max:255',
            'emerg_last_name' => 'required|string|max:255',
            'emerg_address' => 'required|string|max:255',
            'relationship_to_solo_parent' => 'required|string|max:255',
            'emerg_contact_number' => 'required|string|regex:/^09\d{9}$/',
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

        $nextId = SoloParentRecord::max('id') + 1;
        $qr_code = "qr_aics_{$nextId}.svg";

        $record = SoloParentRecord::create([
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
            'religion' => $validated['religion'],
            'philsys_card_number' => $validated['philsys_card_number'],
            'educational_attainment' => $validated['educational_attainment'],
            'employment_status'=> $validated['employment_status'],
            'occupation' => $validated['occupation'],
            'company_agency' => $validated['company_agency'],
            'monthly_income' => $validated['monthly_income'],
            'cellphone_number' => $validated['cellphone_number'],
            'number_of_children'=> $validated['number_of_children'],
            'pantawid_beneficiary' => $validated['pantawid_beneficiary'],
            'household_id' => $validated['household_id'],
            'indigenous_person' => $validated['indigenous_person'],
            'name_of_affliation' => $validated['name_of_affliation'],
            'emerg_first_name' => $validated['emerg_first_name'],
            'emerg_middle_name' => $validated['emerg_middle_name'] ?? null,
            'emerg_last_name' => $validated['emerg_last_name'],
            'emerg_address' => $validated['emerg_address'],
            'relationship_to_solo_parent' => $validated['relationship_to_solo_parent'],
            'emerg_contact_number' => $validated['emerg_contact_number'],
            'qr_code' =>  $qr_code,
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        $qrText = 'SP-' . str_pad($record->id, 3, '0', STR_PAD_LEFT);
        $qrPath = public_path("qrcodes/{$qr_code}");

        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        QrCode::format('svg')->size(200)->generate($qrText, $qrPath);

        return response()->json([
            'success' => true,
            'message' => 'Beneficiary added successfully.'
        ]);
    }

    public function fetchData()
    {
        $records = SoloParentRecord::orderBy('id', 'asc')->get();

        $data = $records->map(function ($record) {
            return [
                'id' => $record->id,
                'photo' => $record->photo,
                'first_name' => $record->first_name,
                'last_name' => $record->last_name,
                'barangay' => $record->barangay,
                'city_municipality' => $record->city_municipality,
                'province' => $record->province,
                'date_of_birth' => date('F j, Y', strtotime($record->date_of_birth)),
                'qr_code' => $record->qr_code,
                'created_at' => $record->created_at->format('F j, Y'),

                // For DataTable display
                'name' => $record->last_name . ', ' . $record->first_name,
                'address' => $record->barangay . ', ' . $record->city_municipality . ', ' . $record->province,
                'sex' => $record->sex,
                'cellphone_number' => $record->cellphone_number,
                'sp_id' => '<span class="text-sm text-white bg-blue-500 rounded-full px-2 py-1">SP-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) . '</span>',
                'number_of_children' => $record->number_of_children,
                'employment_status' => $record->employment_status,
                'status' => '<span class="text-sm bg-yellow-300 text-yellow-700 rounded-full px-2 py-1">Expired</span>',
            ];
        });

        return response()->json(['data' => $data]);
    }
}