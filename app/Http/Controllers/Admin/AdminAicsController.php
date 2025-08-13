<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $qr_code = "qr_aics_{$nextId}.svg";

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
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        $qrText = 'AICS-' . str_pad($record->id, 3, '0', STR_PAD_LEFT);
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
        $records = AicsRecord::orderBy('id', 'desc')->get();

        $data = $records->map(function ($record) {

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
                'status' => '<span class="text-sm bg-yellow-300 text-yellow-700 rounded-full px-2 py-1">Expired</span>',
                'eligibility' => '<span class="text-sm bg-green-300 text-green-700 rounded-full px-2 py-1">Eligible</span>'
            ];
        });

        return response()->json(['data' => $data]);
    }
}