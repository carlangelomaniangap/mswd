<?php

namespace App\Http\Controllers;

use App\Models\SoloParentRecord;
use Illuminate\Http\Request;

class SoloParentQRScannerController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.solo_parent_qrcode_scanner', [ 
            'recordId' => $request->query('qrcode')
        ]);
    }

    public function scan($id) 
    {
        $now = now()->setTimezone('Asia/Manila');

        // Split the QR code value (e.g. "SP-001") into two parts: SP as type and 001 as id
        // $type = record type (SP)
        // $id   = record ID ("001") used to find the correct record
        [$type, $id] = explode('-', $id);

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

        if ($type === 'SP') {
            $record = SoloParentRecord::with('soloParentRequirement')->find($id);

            if ($record) {
                $requirement = $record->soloParentRequirement;

                $requirements = [
                    'valid_id' => $requirement->valid_id,
                    'valid_id_expires_at' => $getExpirationInfo($requirement->valid_id, $requirement->valid_id_expires_at, $requirement->valid_id_updated_at),
                    'birth_certificate' => $requirement->birth_certificate,
                    'birth_certificate_expires_at' => $getExpirationInfo($requirement->birth_certificate, $requirement->birth_certificate_expires_at, $requirement->birth_certificate_updated_at),
                    'solo_parent_id_application_form' => $requirement->solo_parent_id_application_form,
                    'solo_parent_id_application_form_expires_at' => $getExpirationInfo($requirement->solo_parent_id_application_form, $requirement->solo_parent_id_application_form_expires_at, $requirement->solo_parent_id_application_form_updated_at),
                    'affidavit_of_solo_parent' => $requirement->affidavit_of_solo_parent,
                    'affidavit_of_solo_parent_expires_at' => $getExpirationInfo($requirement->affidavit_of_solo_parent, $requirement->affidavit_of_solo_parent_expires_at, $requirement->affidavit_of_solo_parent_updated_at),
                ];
            }
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

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found'
            ], 404);
        }

        $family_members = $record->soloparentfamilyMember->map(function($member) {
            return [
                'sp_record_id' => $member->sp_record_id,
                'family_member_name' => $member->family_member_name,
                'relationship' => $member->relationship,
                'family_member_date_of_birth' => date('F j, Y', strtotime($member->family_member_date_of_birth)),
                'family_member_age' => $member->family_member_age,
                'family_member_sex' => $member->family_member_sex,
                'family_member_civil_status' => $member->family_member_civil_status,
                'family_member_educational_attainment' => $member->family_member_educational_attainment,
                'family_member_occupation' => $member->family_member_occupation,
                'family_member_monthly_income' => number_format($member->family_member_monthly_income),
            ];
        });

        $data = [
            'id' => $record->id,
            'qr_code' => $qr_code,
            'photo' => $photo,
            'first_name' => $record->first_name,
            'middle_name' => $record->middle_name,
            'last_name' => $record->last_name,
            'house_no_unit_floor' => $record->house_no_unit_floor,
            'street' => $record->street,
            'barangay' => $record->barangay,
            'city_municipality' => $record->city_municipality,
            'province' => $record->province,
            'date_of_birth' => date('F j, Y', strtotime($record->date_of_birth)),
            'place_of_birth' => $record->place_of_birth,
            'age' => $record->age,
            'sex' => $record->sex,
            'civil_status' => $record->civil_status,
            'religion' => $record->religion,
            'philsys_card_number' => $record->philsys_card_number,
            'educational_attainment' => $record->educational_attainment,
            'employment_status' => $record->employment_status,
            'occupation' => $record->occupation,
            'company_agency' => $record->company_agency,
            'monthly_income' => $record->monthly_income,
            'cellphone_number' => $record->cellphone_number,
            'number_of_children' => $record->number_of_children,
            'pantawid_beneficiary' => $record->pantawid_beneficiary,
            'household_id' => $record->household_id,
            'indigenous_person' => $record->indigenous_person,
            'name_of_affliation' => $record->name_of_affliation,
            'emerg_first_name' => $record->emerg_first_name,
            'emerg_middle_name' => $record->emerg_middle_name,
            'emerg_last_name' => $record->emerg_last_name,
            'emerg_address' => $record->emerg_address,
            'relationship_to_solo_parent' => $record->relationship_to_solo_parent,
            'emerg_contact_number' => $record->emerg_contact_number,
            'status' => $status,
            'requirements' => $requirements,
            'family_members' => $family_members,
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
