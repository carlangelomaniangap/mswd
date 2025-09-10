<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SoloParentRecord;
use App\Models\SpAbandonmentBySpouseReq;
use App\Models\SpBirthOfChildConsRapeReq;
use App\Models\SpDueToAnnulmentReq;
use App\Models\SpRelativeOfOfwReq;
use App\Models\SpSpouseDeprivedLibertyReq;
use App\Models\SpDueToLegalSeparationReq;
use App\Models\SpLegalGuardianReq;
use App\Models\SpPregnantWomanReq;
use App\Models\SpRelativeConsanguinityReq;
use App\Models\SpSpouseOfOfwReq;
use App\Models\SpSpouseWithPmiReq;
use App\Models\SpUnmarriedPersonReq;
use App\Models\SpWidowOrWidowerReq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSoloParentRequirementsController extends Controller
{
    public function update(Request $request, $id) {

        $validated = $request->all();
        $user = Auth::user();

        $models = [
            SpBirthOfChildConsRapeReq::class,
            SpWidowOrWidowerReq::class,
            SpSpouseDeprivedLibertyReq::class,
            SpSpouseWithPmiReq::class,
            SpDueToLegalSeparationReq::class,
            SpDueToAnnulmentReq::class,
            SpAbandonmentBySpouseReq::class,
            SpSpouseOfOfwReq::class,
            SpRelativeOfOfwReq::class,
            SpUnmarriedPersonReq::class,
            SpLegalGuardianReq::class,
            SpRelativeConsanguinityReq::class,
            SpPregnantWomanReq::class,
        ];

        $columns = [
            SpBirthOfChildConsRapeReq::class => [
                'birth_certificates_of_the_child_or_children',
                'complaint_affidavit',
                'medical_record_on_the_incident_of_rape',
                'solo_parent_has_sole_parental_care_of_a_child',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpWidowOrWidowerReq::class => [
                'birth_certificates_of_the_child_or_children',
                'marriage_certificate',
                'death_certificate_of_the_spouse',
                'a2_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpSpouseDeprivedLibertyReq::class => [
                'birth_certificates_of_the_child_or_children',
                'marriage_certificate',
                'certificate_of_detention',
                'a3_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpSpouseWithPmiReq::class => [
                'birth_certificates_of_the_child_or_children',
                'marriage_cert_or_affidavit_of_cohabitation',
                'certificate_of_detention',
                'a4_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpDueToLegalSeparationReq::class => [
                'birth_certificates_of_the_child_or_children',
                'marriage_certificate',
                'judicial_decree_of_legal_separation',
                'a5_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpDueToAnnulmentReq::class => [
                'birth_certificates_of_the_child_or_children',
                'marriage_certificate_nullity',
                'judicial_decree_of_nullity',
                'a6_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpAbandonmentBySpouseReq::class => [
                'birth_certificates_of_the_child_or_children',
                'marriage_certificate_affidavit',
                'abandonment_of_the_spouse',
                'record_of_the_fact_of_abandonment',
                'a7_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident',
            ],
            SpSpouseOfOfwReq::class => [
                'birth_certificates_of_dependents',
                'marriage_certificate_ofw',
                'ph_overseas_employment',
                'photocopy_of_ofw_passport',
                'proof_of_income',
                'b1_2_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpRelativeOfOfwReq::class => [
                'birth_certificates_of_dependents',
                'marriage_certificate_ofw',
                'ph_overseas_employment',
                'photocopy_of_ofw_passport',
                'proof_of_income',
                'b1_2_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpUnmarriedPersonReq::class => [
                'birth_certificates_of_the_child_or_children',
                'certificate_of_no_marriage',
                'c_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpLegalGuardianReq::class => [
                'birth_certificates_of_the_child_or_children',
                'proof_of_guardianship',
                'd_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpRelativeConsanguinityReq::class => [
                'birth_certificates_of_the_child_or_children',
                'death_cert_cert_incapacity',
                'proof_of_relationship',
                'e_solo_parent_not_cohabiting',
                'solo_parent_is_a_resident_of_the_barangay_and_child',
                'solo_parent_orientation_seminar_cert_of_attendance',
            ],
            SpPregnantWomanReq::class => [
                'medical_record_of_pregnancy',
                'solo_parent_is_a_resident_of_barangay',
                'f_solo_parent_not_cohabiting',
                'solo_parent_orientation_seminar_cert_of_attendance',
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

        $allRequirements = [];

        foreach ($models as $model) {
            $requirements = $model::where('solo_parent_record_id', $id)->get();

            foreach ($requirements as $requirement) {
                foreach ($columns[$model] as $column) {
                    if (isset($validated[$column])) {
                        $status = $validated[$column];

                        if ($requirement->{$column} !== $status) {
                            $requirement->{$column} = $status;
                            $requirement->{$column . '_updated_at'} = now();

                            $expiresCol = $column . '_expires_at';
                            if ($status === 'Complete') {
                                $requirement->{$expiresCol} = now()->addYear();
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

        $record = SoloParentRecord::findOrFail($id);

        if($record->solo_parent_category === 'Birth of a child as a consequence of rape') {
            $requirement = $record->spbirthofchildconsRapeReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->complaint_affidavit,
                $requirement->medical_record_on_the_incident_of_rape,
                $requirement->solo_parent_has_sole_parental_care_of_a_child,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Widow/widower') {
            $requirement = $record->spwidoworwidowerReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->marriage_certificate,
                $requirement->death_certificate_of_the_spouse,
                $requirement->a2_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Spouse of person deprived of liberty') {
            $requirement = $record->spspousedeprivedlibertyReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->marriage_certificate,
                $requirement->cerfiticate_of_detention,
                $requirement->a3_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Spouse of person with physical or mental incapacity') {
            $requirement = $record->spspousewithpmiReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->marriage_cert_or_affidavit_of_cohabitation,
                $requirement->med_record_med_abstract_or_cert_of_confinement,
                $requirement->a4_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Due to legal separation or de facto separation') {
            $requirement = $record->spduetolegalseparationReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->marriage_certificate,
                $requirement->judicial_decree_of_legal_separation,
                $requirement->a5_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Due to nullity or annulment of marriage') {
            $requirement = $record->spduetoannulmentReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->marriage_certificate_nullity,
                $requirement->judicial_decree_of_nullity,
                $requirement->a6_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Abandonment by the spouse') {
            $requirement = $record->spabandonmentbyspouseReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->marriage_certificate_affidavit,
                $requirement->abandonment_of_the_spouse,
                $requirement->record_of_the_fact_of_abandonment,
                $requirement->a7_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident,
            ]);
        } elseif($record->solo_parent_category === 'Spouse of OFW') {
            $requirement = $record->spspouseofofwReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_dependents,
                $requirement->marriage_certificate_ofw,
                $requirement->ph_overseas_employment,
                $requirement->photocopy_of_ofw_passport,
                $requirement->proof_of_income,
                $requirement->b1_2_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Relative of OFW') {
            $requirement = $record->sprelativeofofwReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_dependents,
                $requirement->marriage_certificate_ofw,
                $requirement->ph_overseas_employment,
                $requirement->photocopy_of_ofw_passport,
                $requirement->proof_of_income,
                $requirement->b1_2_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Unmarried person') {
            $requirement = $record->spunmarriedpersonReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->certificate_of_no_marriage,
                $requirement->c_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Legal guardian/Adoptive parent/Foster parent') {
            $requirement = $record->splegalguardianReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->proof_of_guardianship,
                $requirement->d_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Relative within the fourth (4th) civil degree of consanguinity or affinity') {
            $requirement = $record->sprelativeconsanguinityReq;

            $values = array_map('trim', [
                $requirement->birth_certificates_of_the_child_or_children,
                $requirement->death_cert_cert_incapacity,
                $requirement->proof_of_relationship,
                $requirement->e_solo_parent_not_cohabiting,
                $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
            ]);
        } elseif($record->solo_parent_category === 'Pregnant woman') {
            $requirement = $record->sppregnantwomanReq;

            $values = array_map('trim', [
                $requirement->medical_record_of_pregnancy,
                $requirement->solo_parent_is_a_resident_of_barangay,
                $requirement->f_solo_parent_not_cohabiting,
                $requirement->solo_parent_orientation_seminar_cert_of_attendance,
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