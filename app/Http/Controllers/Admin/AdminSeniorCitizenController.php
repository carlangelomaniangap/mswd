<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeniorCitizenRecord;
use App\Models\SeniorRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $nextId = SeniorCitizenRecord::max('id') + 1;
        $qr_code = "qr_aics_{$nextId}.svg";

        $record = SeniorCitizenRecord::create([
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
            'qr_code' =>  $qr_code,
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        $qrText = 'SC-' . str_pad($record->id, 3, '0', STR_PAD_LEFT);
        $qrPath = public_path("qrcodes/{$qr_code}");

        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        QrCode::format('svg')->size(200)->generate($qrText, $qrPath);

        SeniorRequirement::create([
            'senior_record_id' => $record->id,
            'valid_id' => 'Incomplete',
            'valid_id_expires_at' => null,
            'valid_id_updated_at' => null,
            'birth_certificate' => 'Incomplete',
            'birth_certificate_expires_at' => null,
            'birth_certificate_updated_at' => null,
            'barangay_certificate' => 'Incomplete',
            'barangay_certificate_expires_at' => null,
            'barangay_certificate_updated_at' => null,
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
            'birth_certificate' => 'birth_certificate_expires_at',
            'barangay_certificate' => 'barangay_certificate_expires_at',
        ];

        foreach ($columns as $column => $expiresAt) {
            SeniorRequirement::where($expiresAt, '<=', $now)
                ->where($column, '!=', 'Renewal')
                ->update([$column => 'Renewal']);
        }

        $records = SeniorCitizenRecord::with('seniorRequirement')->orderBy('id', 'desc')->get();

        $data = $records->map(function ($record) use ($now) {

            $requirement = $record->seniorRequirement;

            $values = array_map('trim', [
                $requirement->valid_id,
                $requirement->birth_certificate,
                $requirement->barangay_certificate,
            ]);

            if (!in_array('Incomplete', $values, true) && !in_array('Renewal', $values, true) && !in_array('Denied', $values, true)) {
                $status = '<span class="text-sm bg-green-500 text-white rounded-full px-2 py-1">Eligible</span>';
            } elseif (in_array('Incomplete', $values, true)) {
                $status = '<span class="text-sm bg-yellow-300 text-yellow-700 rounded-full px-2 py-1">In Progress</span>';
            } elseif (in_array('Renewal', $values, true)) {
                $status = '<span class="text-sm bg-orange-500 text-white rounded-full px-2 py-1">Expired</span>';
            } elseif (in_array('Denied', $values, true)) {
                $status = '<span class="text-sm bg-red-500 text-white rounded-full px-2 py-1">Not Eligible</span>';
            }

            $getExpirationInfo = function ($status, $expiresAt) use ($now) {

                // If status is "Incomplete", it's still in progress
                if ($status === 'Incomplete') {
                    return "In Progress";
                }

                // If status is "Denied", it's not eligible
                if ($status === 'Denied') {
                    return "Not Eligible";
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

                // If status is "Complete"
                if ($status === 'Complete') {
                    // Get date 3 months before expiration
                    $updatedDate = strtotime("-3 months", $expiresDate);
                    return "Last updated: " . date('F j, Y', $updatedDate);
                }

                // If status is "Renewal"
                if ($status === 'Renewal') {
                    return "Expired: " . date('F j, Y', $expiresDate);
                }
            };

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
                'age' => $record->age,
                'address' => $record->barangay . ', ' . $record->city_municipality . ', ' . $record->province,
                'sex' => $record->sex,
                'cellphone_number' => $record->cellphone_number,
                'sc_id' => '<span class="text-sm text-white bg-blue-500 rounded-full px-2 py-1">SC-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) . '</span>',
                'status' => $status,

                // requirement
                'valid_id' => $requirement->valid_id,
                'valid_id_expires_at' => $getExpirationInfo($requirement->valid_id, $requirement->valid_id_expires_at, $requirement->valid_id_updated_at),
                'birth_certificate' => $requirement->birth_certificate,
                'birth_certificate_expires_at' => $getExpirationInfo($requirement->birth_certificate, $requirement->birth_certificate_expires_at, $requirement->birth_certificate_updated_at),
                'barangay_certificate' => $requirement->barangay_certificate,
                'barangay_certificate_expires_at' => $getExpirationInfo($requirement->barangay_certificate, $requirement->barangay_certificate_expires_at, $requirement->barangay_certificate_updated_at),
            ];
        });

        return response()->json(['data' => $data]);
    }
}