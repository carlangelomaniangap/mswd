<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AicsBurialRequirement;
use App\Models\AicsMedicalAnakRequirement;
use App\Models\AicsMedicalKapatidRequirement;
use App\Models\AicsMedicalMagulangRequirement;
use App\Models\AicsMedicalPartnerRequirement;
use App\Models\AicsMedicalPasyenteRequirement;
use App\Models\AicsMedicalTagapagAlagaRequirement;
use App\Models\AicsRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAicsRequirementsController extends Controller
{
    public function update(Request $request, $id)
    {
        $validated = $request->all();
        $user = Auth::user();

        $models = [
            AicsMedicalMagulangRequirement::class,
            AicsMedicalTagapagAlagaRequirement::class,
            AicsMedicalAnakRequirement::class,
            AicsMedicalPasyenteRequirement::class,
            AicsMedicalPartnerRequirement::class,
            AicsMedicalKapatidRequirement::class,
            AicsBurialRequirement::class,
        ];

        $columns = [
            AicsMedicalMagulangRequirement::class => [
                'personal_letter',
                'brgy_cert_of_indigency_ng_pasyente_at_client',
                'medical_abstract_or_medical_certificate',
                'latest_na_reseta_with_costing',
                'latest_na_laboratory_test_with_costing',
                'hospital_bill',
                'birth_certificate_of_patient',
                'one_valid_id_client_at_pasyente',
                'authorization_letter',
            ],
            AicsMedicalTagapagAlagaRequirement::class => [
                'personal_letter',
                'brgy_cert_of_indigency_ng_pasyente_at_client',
                'medical_abstract_or_medical_certificate',
                'latest_na_reseta_with_costing',
                'latest_na_laboratory_test_with_costing',
                'hospital_bill',
                'brgy_certificate_of_proof_ng_pangangalaga',
                'one_valid_id_client_at_pasyente',
                'authorization_letter',
            ],
            AicsMedicalAnakRequirement::class => [
                'personal_letter',
                'brgy_cert_of_indigency_ng_pasyente_at_client',
                'medical_abstract_or_medical_certificate',
                'latest_na_reseta_with_costing',
                'latest_na_laboratory_test_with_costing',
                'hospital_bill',
                'birth_certificate_of_client',
                'one_valid_id_client_at_pasyente',
                'authorization_letter',
            ],
            AicsMedicalPasyenteRequirement::class => [
                'personal_letter',
                'brgy_cert_of_indigency',
                'medical_abstract_or_medical_certificate',
                'latest_na_reseta_with_costing',
                'latest_na_laboratory_test_with_costing',
                'hospital_bill',
                'one_valid_id',
            ],
            AicsMedicalPartnerRequirement::class => [
                'personal_letter',
                'brgy_cert_of_indigency_ng_pasyente_at_magulang',
                'medical_abstract_or_medical_certificate',
                'latest_na_reseta_with_costing',
                'latest_na_laboratory_test_with_costing',
                'hospital_bill',
                'marriage_cert_or_brgy_cert_of_cohabitation',
                'one_valid_id_client_at_pasyente',
                'authorization_letter',
            ],
            AicsMedicalKapatidRequirement::class => [
                'personal_letter',
                'brgy_cert_of_indigency_ng_pasyente_at_client',
                'medical_abstract_or_medical_certificate',
                'latest_na_reseta_with_costing',
                'latest_na_laboratory_test_with_costing',
                'hospital_bill',
                'birth_certificate_of_pasyente_at_client',
                'one_valid_id_client_at_pasyente',
                'authorization_letter',
            ],
            AicsBurialRequirement::class => [
                'brgy_cert_of_indigency',
                'death_certificate',
                'proof_of_billing_or_promissory_note_from_funeral',
                'marriage_cert_or_birth_cert_or_cert_of_cohabitation',
                'photocopy_of_valid_id',
                'surrender_id',
                'personal_letter',
            ],
        ];

        $now = now()->setTimezone('Asia/Manila');

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

        $allRequirements = [];

        foreach ($models as $model) {
            $requirements = $model::where('aics_record_id', $id)->get();

            foreach ($requirements as $requirement) {
                foreach ($columns[$model] as $column) {
                    if (isset($validated[$column])) {
                        $status = $validated[$column];

                        if ($requirement->{$column} !== $status) {
                            $requirement->{$column} = $status;
                            $requirement->{$column . '_updated_at'} = now();

                            $expiresCol = $column . '_expires_at';
                            if ($status === 'Complete') {
                                $requirement->{$expiresCol} = now()->addMonths(3);
                            } else {
                                $requirement->{$expiresCol} = null;
                            }
                        }
                    }
                }

                $requirement->user_id = $user->id;
                $requirement->user_role = $user->role;
                $requirement->user_name = $user->name;
                $requirement->save();

                // Prepare expiration info for response
                $requirementArray = ['nature_of_problem' => $requirement->nature_of_problem];
                foreach ($columns[$model] as $column) {
                    $requirementArray[$column] = $requirement->{$column};
                    $requirementArray[$column . '_expires_at'] = $getExpirationInfo($requirement->{$column}, $requirement->{$column . '_expires_at'}, $requirement->{$column . '_updated_at'});
                }

                $allRequirements[] = $requirementArray;
            }
        }

        $record = AicsRecord::findOrFail($id);

        if ($record->nature_of_problem === 'Medical (Magulang Ang Magprocess)') {
            $requirement = $record->aicsmedicalmagulangRequirement;

            $values = array_map('trim', [
                $requirement->personal_letter,
                $requirement->brgy_cert_of_indigency_ng_pasyente_at_client,
                $requirement->medical_abstract_or_medical_certificate,
                $requirement->latest_na_reseta_with_costing,
                $requirement->latest_na_laboratory_test_with_costing,
                $requirement->hospital_bill,
                $requirement->birth_certificate_of_patient,
                $requirement->one_valid_id_client_at_pasyente,
                $requirement->authorization_letter,
            ]);
        } elseif ($record->nature_of_problem === 'Medical (Tagapag Alaga Ang Magprocess)') {
            $requirement = $record->aicsmedicaltagapagalagaRequirement;

            $values = array_map('trim', [
                $requirement->personal_letter,
                $requirement->brgy_cert_of_indigency_ng_pasyente_at_client,
                $requirement->medical_abstract_or_medical_certificate,
                $requirement->latest_na_reseta_with_costing,
                $requirement->latest_na_laboratory_test_with_costing,
                $requirement->hospital_bill,
                $requirement->brgy_certificate_of_proof_ng_pangangalaga,
                $requirement->one_valid_id_client_at_pasyente,
                $requirement->authorization_letter,
            ]);
        } elseif ($record->nature_of_problem === 'Medical (Anak Ang Magprocess)') {
                $requirement = $record->aicsmedicalanakRequirement;

            $values = array_map('trim', [
                $requirement->personal_letter,
                $requirement->brgy_cert_of_indigency_ng_pasyente_at_client,
                $requirement->medical_abstract_or_medical_certificate,
                $requirement->latest_na_reseta_with_costing,
                $requirement->latest_na_laboratory_test_with_costing,
                $requirement->hospital_bill,
                $requirement->birth_certificate_of_client,
                $requirement->one_valid_id_client_at_pasyente,
                $requirement->authorization_letter,
            ]);
        } elseif ($record->nature_of_problem === 'Medical (Pasyente Ang Magprocess)') {
            $requirement = $record->aicsmedicalpasyenteRequirement;

            $values = array_map('trim', [
                $requirement->personal_letter,
                $requirement->brgy_cert_of_indigency,
                $requirement->medical_abstract_or_medical_certificate,
                $requirement->latest_na_reseta_with_costing,
                $requirement->latest_na_laboratory_test_with_costing,
                $requirement->hospital_bill,
                $requirement->one_valid_id,
            ]);
        } elseif ($record->nature_of_problem === 'Medical (Asawa/Live in Partner Ang Magprocess)') {
            $requirement = $record->aicsmedicalpartnerRequirement;

            $values = array_map('trim', [
                $requirement->personal_letter,
                $requirement->brgy_cert_of_indigency_ng_pasyente_at_magulang,
                $requirement->medical_abstract_or_medical_certificate,
                $requirement->latest_na_reseta_with_costing,
                $requirement->latest_na_laboratory_test_with_costing,
                $requirement->hospital_bill,
                $requirement->marriage_cert_or_brgy_cert_of_cohabitation,
                $requirement->one_valid_id_client_at_pasyente,
                $requirement->authorization_letter,
            ]);
        } elseif ($record->nature_of_problem === 'Medical (Kapatid Ang Magprocess)') {
            $requirement = $record->aicsmedicalkapatidRequirement;

            $values = array_map('trim', [
                $requirement->personal_letter,
                $requirement->brgy_cert_of_indigency_ng_pasyente_at_client,
                $requirement->medical_abstract_or_medical_certificate,
                $requirement->latest_na_reseta_with_costing,
                $requirement->latest_na_laboratory_test_with_costing,
                $requirement->hospital_bill,
                $requirement->birth_certificate_of_pasyente_at_client,
                $requirement->one_valid_id_client_at_pasyente,
                $requirement->authorization_letter,
            ]);
        } elseif ($record->nature_of_problem === 'Burial') {
            $requirement = $record->aicsburialRequirement;

            $values = array_map('trim', [
                $requirement->brgy_cert_of_indigency,
                $requirement->death_certificate,
                $requirement->proof_of_billing_or_promissory_note_from_funeral,
                $requirement->marriage_cert_or_birth_cert_or_cert_of_cohabitation,
                $requirement->photocopy_of_valid_id,
                $requirement->surrender_id,
                $requirement->personal_letter,
            ]);
        }

        if (in_array('Denied', $values, true)) {
            $status = 'Not Eligible';
        } elseif (in_array('Incomplete', $values, true)) {
            $status = 'In Progress';
        } elseif (in_array('Renewal', $values, true)) {
            $status = 'Expired';
        } elseif (!in_array('Incomplete', $values, true) && !in_array('Renewal', $values, true) && !in_array('Denied', $values, true)) {
            $status = 'Eligible';
        }

        $record->status = $status;
        $record->save();

        return response()->json([
            'success' => true,
            'message' => 'Requirements updated successfully.',
            'requirements' => $allRequirements,
            'status' => $status
        ]);
    }
}