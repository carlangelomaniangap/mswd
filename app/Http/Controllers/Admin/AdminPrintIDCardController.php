<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PwdRecord;
use App\Models\AicsRecord;
use App\Models\SeniorCitizenRecord;
use App\Models\SoloParentRecord;

class AdminPrintIDCardController extends Controller
{
    public function print(Request $request)
    {
        // get the id from the url query
        $id = $request->query('id');

        // separate id to type and recordID
        [$type, $recordID] = explode('-', $id);

        // convert recordID to integer
        $recordID = (int)$recordID;

        if ($type === 'PWD') {
            $record = PwdRecord::findOrFail($recordID );
        } elseif ($type === 'AICS') {
            $record = AicsRecord::findOrFail($recordID );
        } elseif ($type === 'SC') {
            $record = SeniorCitizenRecord::findOrFail($recordID );
        } elseif ($type === 'SP') {
            $record = SoloParentRecord::findOrFail($recordID );
        }

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

        $categoryCode = [
            'Birth of a child as a consequence of rape' => 'A1',
            'Widow/widower' => 'A2',
            'Spouse of person deprived of liberty' => 'A3',
            'Spouse of person with physical or mental incapacity' => 'A4',
            'Due to legal separation or de facto separation' => 'A5',
            'Due to nullity or annulment of marriage' => 'A6',
            'Abandonment by the spouse' => 'A7',
            'Spouse of OFW' => 'B1',
            'Relative of OFW' => 'B2',
            'Unmarried person' => 'C',
            'Legal guardian/Adoptive parent/Foster parent' => 'D',
            'Relative within the fourth (4th) civil degree of consanguinity or affinity' => 'E',
            'Pregnant woman' => 'F',
        ];

        $data = [
            'photo' => $photo,
            'name' => $record->first_name . ' ' . $record->last_name,
            'pwd_id' => 'PWD-' . str_pad($record->id, 3, '0', STR_PAD_LEFT),
            'address' => $record->barangay . ' ' . $record->city_municipality . ' ' . $record->province,
            'sex' => $record->sex,
            'cellphone_number' => $record->cellphone_number,
            'date_of_birth' => date('F j, Y', strtotime($record->date_of_birth)),
            'blood_type' => $record->blood_type,
            'type_of_disability' => $record->type_of_disability,
            'emerg_name' => $record->emerg_first_name . ' ' . $record->emerg_last_name,
            'emerg_address' => $record->emerg_address,
            'relationship_to_pwd' => $record->relationship_to_pwd,
            'emerg_contact_number' => $record->emerg_contact_number,
            'qr_code' => $qr_code,
            'created_at' => date('F j, Y'),
            'user_name' => $record->user_name,

            'aics_id' => 'AICS-' . str_pad($record->id, 3, '0', STR_PAD_LEFT),
            'nature_of_problem' => $record->nature_of_problem,

            'sc_id' => 'SC-' . str_pad($record->id, 3, '0', STR_PAD_LEFT),
            'age' => $record->age,

            'sp_id' => 'SP-' . str_pad($record->id, 3, '0', STR_PAD_LEFT),
            'place_of_birth' => $record->place_of_birth,
            'solo_parent_category' => $categoryCode[$record->solo_parent_category] ?? '',
            'relationship_to_solo_parent' => $record->relationship_to_solo_parent,
        ];

        return view('pages.admin.print_id_card', [
            'data' => $data,
            'type' => $type
        ]);
    }
}