<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PwdRecord;
use App\Models\PwdRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminPwdController extends Controller
{
    public function index()
    {
        return view('pages.admin.pwd');
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
            'type_of_disability' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'blood_type' => 'nullable|in:A+,B+,AB+,O+,A-,B-,AB-,O-',
            'educational_attainment' => 'required|in:No Formal Education,Elementary Undergraduate,Elementary Graduate,High School Undergraduate,High School Graduate,Vocational Graduate,College Undergraduate,College Graduate,Post Graduate',
            'occupation' => 'required|string|max:255',
            'cellphone_number' => 'required|string|regex:/^09\d{9}$/',
            'emerg_first_name' => 'required|string|max:255',
            'emerg_middle_name' => 'nullable|string|max:255',
            'emerg_last_name' => 'required|string|max:255',
            'emerg_address' => 'required|string|max:255',
            'relationship_to_pwd' => 'required|string|max:255',
            'emerg_contact_number' => 'required|string|regex:/^09\d{9}$/',
        ]);

        // Check if a beneficiary with the same first name, last name, and date of birth already exists
        $existing = PwdRecord::where('first_name', $validated['first_name'])
            ->where('last_name', $validated['last_name'])
            ->where('date_of_birth', $validated['date_of_birth'])
            ->first();

        // If a beneficiary is found, return an error response
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Beneficiary already exists.',
            ]);
        }

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

        $nextId = PwdRecord::max('id') + 1;
        $formattedId = str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $qr_code = "qr_pwd_{$formattedId}.svg";

        $record = PwdRecord::create([
            'photo' => $photoPath,
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'house_no_unit_floor' => $validated['house_no_unit_floor'] ?? null,
            'street' => $validated['street'] ?? null,
            'barangay' => $validated['barangay'],
            'city_municipality' => $validated['city_municipality'],
            'province' => $validated['province'],
            'type_of_disability' => $validated['type_of_disability'],
            'date_of_birth' => $validated['date_of_birth'],
            'place_of_birth' => $validated['place_of_birth'],
            'age' => $validated['age'],
            'sex' => $validated['sex'],
            'civil_status' => $validated['civil_status'],
            'blood_type' => $validated['blood_type'] ?? null,
            'educational_attainment' => $validated['educational_attainment'],
            'occupation' => $validated['occupation'],
            'cellphone_number' => $validated['cellphone_number'],
            'emerg_first_name' => $validated['emerg_first_name'],
            'emerg_middle_name' => $validated['emerg_middle_name'] ?? null,
            'emerg_last_name' => $validated['emerg_last_name'],
            'emerg_address' => $validated['emerg_address'],
            'relationship_to_pwd' => $validated['relationship_to_pwd'],
            'emerg_contact_number' => $validated['emerg_contact_number'],
            'qr_code' => $qr_code,
            'status'=> 'In Progress',
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        $qrText = url("/pwd/record/data/scan?qrcode=" . 'PWD-' . str_pad($record->id, 3, '0', STR_PAD_LEFT));
        $qrPath = public_path("qrcodes/{$qr_code}");

        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        QrCode::format('svg')->size(200)->generate($qrText, $qrPath);

        PwdRequirement::create([
            'pwd_record_id' => $record->id,
            'valid_id' => 'Incomplete',
            'valid_id_expires_at' => null,
            'valid_id_updated_at' => null,
            'medical_certificate' => 'Incomplete',
            'medical_certificate_expires_at' => null,
            'medical_certificate_updated_at' => null,
            'barangay_certificate' => 'Incomplete',
            'barangay_certificate_expires_at' => null,
            'barangay_certificate_updated_at' => null,
            'birth_certificate' => 'Incomplete',
            'birth_certificate_expires_at' => null,
            'birth_certificate_updated_at' => null,
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Beneficiary added successfully.'
        ]);
    }

    public function fetchData()
    {
        $now = now()->setTimezone('Asia/Manila');
        // $now = Carbon::create(2025, 7, 16, 0, 0, 0, 'Asia/Manila');

        $columns = [
            'valid_id' => 'valid_id_expires_at',
            'medical_certificate' => 'medical_certificate_expires_at',
            'barangay_certificate' => 'barangay_certificate_expires_at',
            'birth_certificate' => 'birth_certificate_expires_at',
        ];

        foreach ($columns as $column => $expiresAt) {
            $expiredRequirements = PwdRequirement::where($expiresAt, '<=', $now)
                ->where($column, '!=', 'Renewal')
                ->get();

            foreach ($expiredRequirements as $req) {
                $req->update([$column => 'Renewal']);

                $record = $req->pwdRecord;
                if ($record) {
                    $record->status = 'Expired';
                    $record->save();
                }
            }
        }

        $records = PwdRecord::with('pwdRequirement')->orderBy('id', 'desc')->get();

        $data = $records->map(function ($record) use ($now) {

            $requirement = $record->pwdRequirement;

            $statusStyles = [
                'Eligible' => 'bg-green-500 text-white',
                'In Progress' => 'bg-yellow-300 text-yellow-700',
                'Expired' => 'bg-orange-500 text-white',
                'Not Eligible' => 'bg-red-500 text-white',
            ];

            // Get the style based on the record’s status
            $style = $statusStyles[$record->status];

            // Combine the style with status
            $status = "<span class='text-sm rounded-full px-2 py-1 {$style}'>$record->status</span>";

            $getExpirationInfo = function ($status, $expiresAt, $updatedAt) use ($now) {

                // If status is "Incomplete", it's still in progress
                if ($status === 'Incomplete') {
                    return "In Progress";
                }

                // If status is "Denied", it's not eligible
                if ($status === 'Denied') {
                    return "Not Eligible";
                }

                // If status is "Complete"
                if ($status === 'Complete') {
                    // Get date 3 months before expiration
                    return "Last updated: " . date('F j, Y', strtotime($updatedAt));
                }

                // Convert expiration date to timestamp
                $expiresDate = strtotime($expiresAt);
                // Get current time as timestamp
                $nowDate = $now->timestamp;

                // Get how many seconds have passed since expiration
                $diffInSeconds = $nowDate - $expiresDate;

                // If already expired
                if ($diffInSeconds > 0) {
                    // Get full days since it expired
                    $daysOverdue = floor($diffInSeconds / (60 * 60 * 24)); // Calculate days overdue
                    // Get full hours after days are removed
                    $hoursOverdue = floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60)); // Calculate remaining hours

                    // Return days if overdue by at least 1 day
                    if ($daysOverdue > 0) {
                        return "Expired: More than {$daysOverdue} " . ($daysOverdue == 1 ? 'day' : 'days') . " in renewal";
                    }

                    // Return hours if overdue by at least 1 hour
                    if ($hoursOverdue > 0) {
                        return "Expired: More than {$hoursOverdue} " . ($hoursOverdue == 1 ? 'hour' : 'hours') . " in renewal";
                    }

                    // Get full minutes after hours are removed
                    $minutesOverdue = floor(($diffInSeconds % (60 * 60)) / 60);

                    // Return minutes if overdue by at least 1 minute
                    if ($minutesOverdue > 0) {
                        return "Expired: More than {$minutesOverdue} minute" . ($minutesOverdue == 1 ? '' : 's') . " in renewal";
                    }

                    // If overdue by less than 1 minute
                    return "Expired: Less than a minute ago";
                };

                // If status is "Renewal"
                if ($status === 'Renewal') {
                    return "Expired: " . date('F j, Y', $expiresDate);
                }
            };

            // Initialize Photo variable with a value of null
            $photo = null;

            // Check if the photo filename is not empty
            if (!empty($record->photo)) {
                // Path to the beneficiary photo in the public directory
                $photoPath = public_path('beneficiary_photos/' . $record->photo);

                // Verify that the photo file actually exists at the public path
                if (file_exists($photoPath)) {
                    $imageData = file_get_contents($photoPath);
                    $extension = strtolower(pathinfo($photoPath, PATHINFO_EXTENSION));
                    if ($extension === 'png') {
                        $imageType = 'image/png';
                    } elseif ($extension === 'jpg' || $extension === 'jpeg') {
                        $imageType = 'image/jpeg';
                    }
                    $photo = 'data:' . $imageType . ';base64,' . base64_encode($imageData);
                } else {
                    // If the photo filename is not found, show the default photo
                    $defaultPath = public_path('images/default_photo.png');
                    $imageData = file_get_contents($defaultPath);
                    $imageType = 'image/png';
                    $photo = 'data:' . $imageType . ';base64,' . base64_encode($imageData);
                }
            } else {
                // If the photo filename is empty, show the default photo
                $defaultPath = public_path('images/default_photo.png');
                $imageData = file_get_contents($defaultPath);
                $imageType = 'image/png';
                $photo = 'data:' . $imageType . ';base64,' . base64_encode($imageData);
            }

            // Initialize QR code variable with a value of null
            $qr_code = null;

            // Check if the qr code filename is not empty
            if (!empty($record->qr_code)) {
                // Path to the qr code in the public directory
                $qrcodePath = public_path('qrcodes/' . $record->qr_code);

                // Verify that the qr code file actually exists at the public path
                if (file_exists($qrcodePath)) {
                    $svgData = file_get_contents($qrcodePath);
                    $qr_code = 'data:image/svg+xml;base64,' . base64_encode($svgData);
                }
            }

            return [
                'id' => $record->id,
                'first_name' => $record->first_name,
                'middle_name' => $record->middle_name,
                'last_name' => $record->last_name,
                'house_no_unit_floor' => $record->house_no_unit_floor,
                'street' => $record->street,
                'barangay' => $record->barangay,
                'city_municipality' => $record->city_municipality,
                'province' => $record->province,
                'photo' => $photo,
                'type_of_disability' => $record->type_of_disability,
                'date_of_birth' => $record->date_of_birth,
                'place_of_birth' => $record->place_of_birth,
                'age' => $record->age,
                'civil_status' => $record->civil_status,
                'blood_type' => $record->blood_type,
                'educational_attainment' => $record->educational_attainment,
                'occupation' => $record->occupation,
                'emerg_first_name' => $record->emerg_first_name,
                'emerg_middle_name' => $record->emerg_middle_name,
                'emerg_last_name' => $record->emerg_last_name,
                'emerg_address' => $record->emerg_address,
                'relationship_to_pwd' => $record->relationship_to_pwd,
                'emerg_contact_number' => $record->emerg_contact_number,
                'qr_code' => $qr_code,
                'created_at' => $record->created_at->format('F j, Y'),

                // For DataTable display
                'name' => $record->last_name . ', ' . $record->first_name,
                'address' => $record->barangay . ', ' . $record->city_municipality . ', ' . $record->province,
                'sex' => $record->sex,
                'cellphone_number' => $record->cellphone_number,
                'pwd_id' => '<span class="text-sm text-white bg-blue-500 rounded-full px-2 py-1">PWD-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) . '</span>',
                'status' => $status,

                // requirement
                'valid_id' => $requirement->valid_id,
                'valid_id_expires_at' => $getExpirationInfo($requirement->valid_id, $requirement->valid_id_expires_at, $requirement->valid_id_updated_at),
                'medical_certificate' => $requirement->medical_certificate,
                'medical_certificate_expires_at' => $getExpirationInfo($requirement->medical_certificate, $requirement->medical_certificate_expires_at, $requirement->medical_certificate_updated_at),
                'barangay_certificate' => $requirement->barangay_certificate,
                'barangay_certificate_expires_at' => $getExpirationInfo($requirement->barangay_certificate, $requirement->barangay_certificate_expires_at, $requirement->barangay_certificate_updated_at),
                'birth_certificate' => $requirement->birth_certificate,
                'birth_certificate_expires_at' => $getExpirationInfo($requirement->birth_certificate, $requirement->birth_certificate_expires_at, $requirement->birth_certificate_updated_at),
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {   
        $record = PwdRecord::findOrFail($id);
        
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
            'type_of_disability' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'blood_type' => 'nullable|in:A+,B+,AB+,O+,A-,B-,AB-,O-',
            'educational_attainment' => 'required|in:No Formal Education,Elementary Undergraduate,Elementary Graduate,High School Undergraduate,High School Graduate,Vocational Graduate,College Undergraduate,College Graduate,Post Graduate',
            'occupation' => 'required|string|max:255',
            'cellphone_number' => 'required|string|regex:/^09\d{9}$/',
            'emerg_first_name' => 'required|string|max:255',
            'emerg_middle_name' => 'nullable|string|max:255',
            'emerg_last_name' => 'required|string|max:255',
            'emerg_address' => 'required|string|max:255',
            'relationship_to_pwd' => 'required|string|max:255',
            'emerg_contact_number' => 'required|string|regex:/^09\d{9}$/',
        ]);

        // Check if a beneficiary with the same first name, last name, and date of birth already exists
        $existing = PwdRecord::where('first_name', $validated['first_name'])
            ->where('last_name', $validated['last_name'])
            ->where('date_of_birth', $validated['date_of_birth'])
            ->first();

        // If a beneficiary is found, return an error response
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Beneficiary already exists.',
            ]);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = $photo->getClientOriginalName();
            $photo->move(public_path('beneficiary_photos'), $photoName);
            $record->photo = $photoName;
        }

        $user = Auth::user();

        $record->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'house_no_unit_floor' => $validated['house_no_unit_floor'] ?? null,
            'street' => $validated['street'] ?? null,
            'barangay' => $validated['barangay'],
            'city_municipality' => $validated['city_municipality'],
            'province' => $validated['province'],
            'type_of_disability' => $validated['type_of_disability'],
            'date_of_birth' => $validated['date_of_birth'],
            'place_of_birth' => $validated['place_of_birth'],
            'age' => $validated['age'],
            'sex' => $validated['sex'],
            'civil_status' => $validated['civil_status'],
            'blood_type' => $validated['blood_type'] ?? null,
            'educational_attainment' => $validated['educational_attainment'],
            'occupation' => $validated['occupation'],
            'cellphone_number' => $validated['cellphone_number'],
            'emerg_first_name' => $validated['emerg_first_name'],
            'emerg_middle_name' => $validated['emerg_middle_name'] ?? null,
            'emerg_last_name' => $validated['emerg_last_name'],
            'emerg_address' => $validated['emerg_address'],
            'relationship_to_pwd' => $validated['relationship_to_pwd'],
            'emerg_contact_number' => $validated['emerg_contact_number'],
            'updated_by' => $user->id,
            'updated_by_role' => $user->role,
            'updated_by_name' => $user->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Beneficiary updated successfully.'
        ]);
    }
}