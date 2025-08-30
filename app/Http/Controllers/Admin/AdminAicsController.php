<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AicsBurialRequirement;
use App\Models\AicsMedicalRequirement;
use App\Models\AicsRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminAicsController extends Controller
{
    public function index()
    {
        return view('pages.admin.aics');
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
            'nature_of_problem' => 'required|in:Medical,Financial,Educational,Burial,Transportation,Food,Others',
            'problem_description' => 'required|string|max:255',
        ]);

        // Check if a beneficiary with the same first name, last name, and date of birth already exists
        $existing = AicsRecord::where('first_name', $validated['first_name'])
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

        $nextId = AicsRecord::max('id') + 1;
        $formattedId = str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $qr_code = "qr_aics_{$formattedId}.svg";

        $record = AicsRecord::create([
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
            'nature_of_problem' => $validated['nature_of_problem'],
            'problem_description' => $validated['problem_description'],
            'qr_code' => $qr_code,
            'status'=> 'In Progress',
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        $qrText = url("/aics/record/data/scan?qrcode=" . 'AICS-' . str_pad($record->id, 3, '0', STR_PAD_LEFT));
        $qrPath = public_path("qrcodes/{$qr_code}");

        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        QrCode::format('svg')->size(200)->generate($qrText, $qrPath);

        if($record->nature_of_problem === 'Medical') {
            AicsMedicalRequirement::create([
                'aics_record_id' => $record->id,
                'letter_to_the_mayor' => 'Incomplete',
                'letter_to_the_mayor_expires_at' => null,
                'letter_to_the_mayor_updated_at' => null,
                'medical_certificate' => 'Incomplete',
                'medical_certificate_expires_at' => null,
                'medical_certificate_updated_at' => null,
                'laboratory_or_prescription' => 'Incomplete',
                'laboratory_or_prescription_expires_at' => null,
                'laboratory_or_prescription_updated_at' => null,
                'barangay_indigency' => 'Incomplete',
                'barangay_indigency_expires_at' => null,
                'barangay_indigency_updated_at' => null,
                'valid_id' => 'Incomplete',
                'valid_id_expires_at' => null,
                'valid_id_updated_at' => null,
                'cedula' => 'Incomplete',
                'cedula_expires_at' => null,
                'cedula_updated_at' => null,
                'barangay_certificate_or_marriage_contract' => 'Incomplete',
                'barangay_certificate_or_marriage_contract_expires_at' => null,
                'barangay_certificate_or_marriage_contract_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif ($record->nature_of_problem === 'Financial') {

        } elseif ($record->nature_of_problem === 'Educational') {

        } elseif ($record->nature_of_problem === 'Burial') {
            AicsBurialRequirement::create([
                'aics_record_id' => $record->id,
                'letter_to_the_mayor' => 'Incomplete',
                'letter_to_the_mayor_expires_at' => null,
                'letter_to_the_mayor_updated_at' => null,
                'death_certificate' => 'Incomplete',
                'death_certificate_expires_at' => null,
                'death_certificate_updated_at' => null,
                'funeral_contract' => 'Incomplete',
                'funeral_contract_expires_at' => null,
                'funeral_contract_updated_at' => null,
                'barangay_indigency' => 'Incomplete',
                'barangay_indigency_expires_at' => null,
                'barangay_indigency_updated_at' => null,
                'valid_id' => 'Incomplete',
                'valid_id_expires_at' => null,
                'valid_id_updated_at' => null,
                'cedula' => 'Incomplete',
                'cedula_expires_at' => null,
                'cedula_updated_at' => null,
                'barangay_certificate_or_marriage_contract' => 'Incomplete',
                'barangay_certificate_or_marriage_contract_expires_at' => null,
                'barangay_certificate_or_marriage_contract_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif ($record->nature_of_problem === 'Transportation') {

        } elseif ($record->nature_of_problem === 'Food') {

        }

        return response()->json([
            'success' => true,
            'message' => 'Beneficiary added successfully.'
        ]);
    }

    public function fetchData()
    {
        $now = now()->setTimezone('Asia/Manila');
        // $now = Carbon::create(2025, 7, 16, 0, 0, 0, 'Asia/Manila');

        $models = [
            AicsMedicalRequirement::class => [
                'letter_to_the_mayor' => 'letter_to_the_mayor_expires_at',
                'medical_certificate' => 'medical_certificate_expires_at',
                'laboratory_or_prescription' => 'laboratory_or_prescription_expires_at',
                'barangay_indigency' => 'barangay_indigency_expires_at',
                'valid_id' => 'valid_id_expires_at',
                'cedula' => 'cedula_expires_at',
                'barangay_certificate_or_marriage_contract' => 'barangay_certificate_or_marriage_contract_expires_at',
            ],
            AicsBurialRequirement::class => [
                'letter_to_the_mayor' => 'letter_to_the_mayor_expires_at',
                'death_certificate' => 'death_certificate_expires_at',
                'funeral_contract' => 'funeral_contract_expires_at',
                'barangay_indigency' => 'barangay_indigency_expires_at',
                'valid_id' => 'valid_id_expires_at',
                'cedula' => 'cedula_expires_at',
                'barangay_certificate_or_marriage_contract' => 'barangay_certificate_or_marriage_contract_expires_at',
            ],
        ];

        foreach ($models as $model => $columns) {
            foreach ($columns as $column => $expiresAt) {
                $expiredRequirements = $model::where($expiresAt, '<=', $now)
                    ->where($column, '!=', 'Renewal')
                    ->get();

                foreach ($expiredRequirements as $req) {
                    $req->update([$column => 'Renewal']);

                    $record = $req->aicsRecord;
                    if ($record) {
                        $record->status = 'Expired';
                        $record->save();
                    }
                }
            }
        }

        $records = AicsRecord::with([
            'aicsmedicalRequirement',
            // 'aicsfinancialRequirement',
            // 'aicseducationalRequirement',
            'aicsburialRequirement',
            // 'aicstransportationRequirement',
            // 'aicsfoodRequirement',
        ])->orderBy('id', 'desc')->get();

        $data = $records->map(function ($record) use ($now) {

            $getExpirationInfo = function ($status, $expiresAt, $updatedAt) use ($now) {

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
                    return "Last updated: " . date('F j, Y', strtotime($updatedAt));
                }

                // If status is "Renewal"
                if ($status === 'Renewal') {
                    return "Expired: " . date('F j, Y', $expiresDate);
                }
            };

            if ($record->nature_of_problem === 'Medical') {
                $requirement = $record->aicsmedicalRequirement;

                $requirements = [
                    'letter_to_the_mayor' => $requirement->letter_to_the_mayor,
                    'letter_to_the_mayor_expires_at' => $getExpirationInfo($requirement->letter_to_the_mayor, $requirement->letter_to_the_mayor_expires_at, $requirement->letter_to_the_mayor_updated_at),
                    'medical_certificate' => $requirement->medical_certificate,
                    'medical_certificate_expires_at' => $getExpirationInfo($requirement->medical_certificate, $requirement->medical_certificate_expires_at, $requirement->medical_certificate_updated_at),
                    'laboratory_or_prescription' => $requirement->laboratory_or_prescription,
                    'laboratory_or_prescription_expires_at' => $getExpirationInfo($requirement->laboratory_or_prescription, $requirement->laboratory_or_prescription_expires_at, $requirement->laboratory_or_prescription_updated_at),
                    'barangay_indigency' => $requirement->barangay_indigency,
                    'barangay_indigency_expires_at' => $getExpirationInfo($requirement->barangay_indigency, $requirement->barangay_indigency_expires_at, $requirement->barangay_indigency_updated_at),
                    'valid_id' => $requirement->valid_id,
                    'valid_id_expires_at' => $getExpirationInfo($requirement->valid_id, $requirement->valid_id_expires_at, $requirement->valid_id_updated_at),
                    'cedula' => $requirement->cedula,
                    'cedula_expires_at' => $getExpirationInfo($requirement->cedula, $requirement->cedula_expires_at, $requirement->cedula_updated_at),
                    'barangay_certificate_or_marriage_contract' => $requirement->barangay_certificate_or_marriage_contract,
                    'barangay_certificate_or_marriage_contract_expires_at' => $getExpirationInfo($requirement->barangay_certificate_or_marriage_contract, $requirement->barangay_certificate_or_marriage_contract_expires_at, $requirement->barangay_certificate_or_marriage_contract_updated_at),
                ];
            } elseif ($record->nature_of_problem === 'Financial') {
                
            } elseif ($record->nature_of_problem === 'Educational') {
                
            } elseif ($record->nature_of_problem === 'Burial') {
                $requirement = $record->aicsburialRequirement;

                $requirements = [
                    'letter_to_the_mayor' => $requirement->letter_to_the_mayor,
                    'letter_to_the_mayor_expires_at' => $getExpirationInfo($requirement->letter_to_the_mayor, $requirement->letter_to_the_mayor_expires_at, $requirement->letter_to_the_mayor_updated_at),
                    'death_certificate' => $requirement->death_certificate,
                    'death_certificate_expires_at' => $getExpirationInfo($requirement->death_certificate, $requirement->death_certificate_expires_at, $requirement->death_certificate_updated_at),
                    'funeral_contract' => $requirement->funeral_contract,
                    'funeral_contract_expires_at' => $getExpirationInfo($requirement->funeral_contract, $requirement->funeral_contract_expires_at, $requirement->funeral_contract_updated_at),
                    'barangay_indigency' => $requirement->barangay_indigency,
                    'barangay_indigency_expires_at' => $getExpirationInfo($requirement->barangay_indigency, $requirement->barangay_indigency_expires_at, $requirement->barangay_indigency_updated_at),
                    'valid_id' => $requirement->valid_id,
                    'valid_id_expires_at' => $getExpirationInfo($requirement->valid_id, $requirement->valid_id_expires_at, $requirement->valid_id_updated_at),
                    'cedula' => $requirement->cedula,
                    'cedula_expires_at' => $getExpirationInfo($requirement->cedula, $requirement->cedula_expires_at, $requirement->cedula_updated_at),
                    'barangay_certificate_or_marriage_contract' => $requirement->barangay_certificate_or_marriage_contract,
                    'barangay_certificate_or_marriage_contract_expires_at' => $getExpirationInfo($requirement->barangay_certificate_or_marriage_contract, $requirement->barangay_certificate_or_marriage_contract_expires_at, $requirement->barangay_certificate_or_marriage_contract_updated_at),
                ];
            } elseif ($record->nature_of_problem === 'Transportation') {
                
            } elseif ($record->nature_of_problem === 'Food') {
                
            }

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
                'photo' => $photo,
                'first_name' => $record->first_name,
                'last_name' => $record->last_name,
                'barangay' => $record->barangay,
                'city_municipality' => $record->city_municipality,
                'province' => $record->province,
                'date_of_birth' => date('F j, Y', strtotime($record->date_of_birth)),
                'place_of_birth' => $record->place_of_birth,
                'age' => $record->age,
                'civil_status' => $record->civil_status,
                'educational_attainment' => $record->educational_attainment,
                'occupation' => $record->occupation,
                'nature_of_problem' => $record->nature_of_problem,
                'problem_description' => $record->problem_description,
                'qr_code' => $qr_code,

                // For DataTable display
                'name' => $record->last_name . ', ' . $record->first_name,
                'created_at' => $record->created_at->format('F j, Y'),
                'address' => $record->barangay . ', ' . $record->city_municipality . ', ' . $record->province,
                'sex' => $record->sex,
                'cellphone_number' => $record->cellphone_number,
                'aics_id' => '<span class="text-sm text-white bg-blue-500 rounded-full px-2 py-1">AICS-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) . '</span>',
                'status' => $status,

                // requirements
                'requirements' => $requirements,
            ];
        });

        return response()->json(['data' => $data]);
    }
}