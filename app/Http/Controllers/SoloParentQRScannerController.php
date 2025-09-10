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

        if ($type === 'SP') {
            $record = SoloParentRecord::with('soloparentfamilyMember')->find($id);

            $requirements = [];

            if ($record->solo_parent_category === 'Birth of a child as a consequence of rape') {
                $requirement = $record->spbirthofchildconsRapeReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'complaint_affidavit' => $requirement->complaint_affidavit,
                    'complaint_affidavit_expires_at' => $getExpirationInfo($requirement->complaint_affidavit, $requirement->complaint_affidavit_expires_at, $requirement->complaint_affidavit_updated_at),
                    'medical_record_on_the_incident_of_rape' => $requirement->medical_record_on_the_incident_of_rape,
                    'medical_record_on_the_incident_of_rape_expires_at' => $getExpirationInfo($requirement->medical_record_on_the_incident_of_rape, $requirement->medical_record_on_the_incident_of_rape_expires_at, $requirement->medical_record_on_the_incident_of_rape_updated_at),
                    'solo_parent_has_sole_parental_care_of_a_child' => $requirement->solo_parent_has_sole_parental_care_of_a_child,
                    'solo_parent_has_sole_parental_care_of_a_child_expires_at' => $getExpirationInfo($requirement->solo_parent_has_sole_parental_care_of_a_child, $requirement->solo_parent_has_sole_parental_care_of_a_child_expires_at, $requirement->solo_parent_has_sole_parental_care_of_a_child_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Widow/widower') {
                $requirement = $record->spwidoworwidowerReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'marriage_certificate' => $requirement->marriage_certificate,
                    'marriage_certificate_expires_at' => $getExpirationInfo($requirement->marriage_certificate, $requirement->marriage_certificate_expires_at, $requirement->marriage_certificate_updated_at),
                    'death_certificate_of_the_spouse' => $requirement->death_certificate_of_the_spouse,
                    'death_certificate_of_the_spouse_expires_at' => $getExpirationInfo($requirement->death_certificate_of_the_spouse, $requirement->death_certificate_of_the_spouse_expires_at, $requirement->death_certificate_of_the_spouse_updated_at),
                    'a2_solo_parent_not_cohabiting' => $requirement->a2_solo_parent_not_cohabiting,
                    'a2_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->a2_solo_parent_not_cohabiting, $requirement->a2_solo_parent_not_cohabiting_expires_at, $requirement->a2_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Spouse of person deprived of liberty') {
                $requirement = $record->spspousedeprivedlibertyReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'marriage_certificate' => $requirement->marriage_certificate,
                    'marriage_certificate_expires_at' => $getExpirationInfo($requirement->marriage_certificate, $requirement->marriage_certificate_expires_at, $requirement->marriage_certificate_updated_at),
                    'certificate_of_detention' => $requirement->certificate_of_detention,
                    'certificate_of_detention_expires_at' => $getExpirationInfo($requirement->certificate_of_detention, $requirement->certificate_of_detention_expires_at, $requirement->certificate_of_detention_updated_at),
                    'a3_solo_parent_not_cohabiting' => $requirement->a3_solo_parent_not_cohabiting,
                    'a3_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->a3_solo_parent_not_cohabiting, $requirement->a3_solo_parent_not_cohabiting_expires_at, $requirement->a3_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Spouse of person with physical or mental incapacity') {
                $requirement = $record->spspousewithpmiReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'marriage_cert_or_affidavit_of_cohabitation' => $requirement->marriage_cert_or_affidavit_of_cohabitation,
                    'marriage_cert_or_affidavit_of_cohabitation_expires_at' => $getExpirationInfo($requirement->marriage_cert_or_affidavit_of_cohabitation, $requirement->marriage_cert_or_affidavit_of_cohabitation_expires_at, $requirement->marriage_cert_or_affidavit_of_cohabitation_updated_at),
                    'med_record_med_abstract_or_cert_of_confinement' => $requirement->med_record_med_abstract_or_cert_of_confinement,
                    'med_record_med_abstract_or_cert_of_confinement_expires_at' => $getExpirationInfo($requirement->med_record_med_abstract_or_cert_of_confinement, $requirement->med_record_med_abstract_or_cert_of_confinement_expires_at, $requirement->med_record_med_abstract_or_cert_of_confinement_updated_at),
                    'a4_solo_parent_not_cohabiting' => $requirement->a4_solo_parent_not_cohabiting,
                    'a4_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->a4_solo_parent_not_cohabiting, $requirement->a4_solo_parent_not_cohabiting_expires_at, $requirement->a4_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Due to legal separation or de facto separation') {
                $requirement = $record->spduetolegalseparationReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'marriage_certificate' => $requirement->marriage_certificate,
                    'marriage_certificate_expires_at' => $getExpirationInfo($requirement->marriage_certificate, $requirement->marriage_certificate_expires_at, $requirement->marriage_certificate_updated_at),
                    'judicial_decree_of_legal_separation' => $requirement->judicial_decree_of_legal_separation,
                    'judicial_decree_of_legal_separation_expires_at' => $getExpirationInfo($requirement->judicial_decree_of_legal_separation, $requirement->judicial_decree_of_legal_separation_expires_at, $requirement->judicial_decree_of_legal_separation_updated_at),
                    'a5_solo_parent_not_cohabiting' => $requirement->a5_solo_parent_not_cohabiting,
                    'a5_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->a5_solo_parent_not_cohabiting, $requirement->a5_solo_parent_not_cohabiting_expires_at, $requirement->a5_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Due to nullity or annulment of marriage') {
                $requirement = $record->spduetoannulmentReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'marriage_certificate_nullity' => $requirement->marriage_certificate_nullity,
                    'marriage_certificate_nullity_expires_at' => $getExpirationInfo($requirement->marriage_certificate_nullity, $requirement->marriage_certificate_nullity_expires_at, $requirement->marriage_certificate_nullity_updated_at),
                    'judicial_decree_of_nullity' => $requirement->judicial_decree_of_nullity,
                    'judicial_decree_of_nullity_expires_at' => $getExpirationInfo($requirement->judicial_decree_of_nullity, $requirement->judicial_decree_of_nullity_expires_at, $requirement->judicial_decree_of_nullity_updated_at),
                    'a6_solo_parent_not_cohabiting' => $requirement->a6_solo_parent_not_cohabiting,
                    'a6_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->a6_solo_parent_not_cohabiting, $requirement->a6_solo_parent_not_cohabiting_expires_at, $requirement->a6_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Abandonment by the spouse') {
                $requirement = $record->spabandonmentbyspouseReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'marriage_certificate_affidavit' => $requirement->marriage_certificate_affidavit,
                    'marriage_certificate_affidavit_expires_at' => $getExpirationInfo($requirement->marriage_certificate_affidavit, $requirement->marriage_certificate_affidavit_expires_at, $requirement->marriage_certificate_affidavit_updated_at),
                    'abandonment_of_the_spouse' => $requirement->abandonment_of_the_spouse,
                    'abandonment_of_the_spouse_expires_at' => $getExpirationInfo($requirement->abandonment_of_the_spouse, $requirement->abandonment_of_the_spouse_expires_at, $requirement->abandonment_of_the_spouse_updated_at),
                    'record_of_the_fact_of_abandonment' => $requirement->record_of_the_fact_of_abandonment,
                    'record_of_the_fact_of_abandonment_expires_at' => $getExpirationInfo($requirement->record_of_the_fact_of_abandonment, $requirement->record_of_the_fact_of_abandonment_expires_at, $requirement->record_of_the_fact_of_abandonment_updated_at),
                    'a7_solo_parent_not_cohabiting' => $requirement->a7_solo_parent_not_cohabiting,
                    'a7_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->a7_solo_parent_not_cohabiting, $requirement->a7_solo_parent_not_cohabiting_expires_at, $requirement->a7_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident' => $requirement->solo_parent_is_a_resident,
                    'solo_parent_is_a_resident_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident, $requirement->solo_parent_is_a_resident_expires_at, $requirement->solo_parent_is_a_resident_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Spouse of OFW') {
                $requirement = $record->spspouseofofwReq;

                $requirements = [
                    'birth_certificates_of_dependents' => $requirement->birth_certificates_of_dependents,
                    'birth_certificates_of_dependents_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_dependents, $requirement->birth_certificates_of_dependents_expires_at, $requirement->birth_certificates_of_dependents_updated_at),
                    'marriage_certificate_ofw' => $requirement->marriage_certificate_ofw,
                    'marriage_certificate_ofw_expires_at' => $getExpirationInfo($requirement->marriage_certificate_ofw, $requirement->marriage_certificate_ofw_expires_at, $requirement->marriage_certificate_ofw_updated_at),
                    'ph_overseas_employment' => $requirement->ph_overseas_employment,
                    'ph_overseas_employment_expires_at' => $getExpirationInfo($requirement->ph_overseas_employment, $requirement->ph_overseas_employment_expires_at, $requirement->ph_overseas_employment_updated_at),
                    'photocopy_of_ofw_passport' => $requirement->photocopy_of_ofw_passport,
                    'photocopy_of_ofw_passport_expires_at' => $getExpirationInfo($requirement->photocopy_of_ofw_passport, $requirement->photocopy_of_ofw_passport_expires_at, $requirement->photocopy_of_ofw_passport_updated_at),
                    'proof_of_income' => $requirement->proof_of_income,
                    'proof_of_income_expires_at' => $getExpirationInfo($requirement->proof_of_income, $requirement->proof_of_income_expires_at, $requirement->proof_of_income_updated_at),
                    'b1_2_solo_parent_not_cohabiting' => $requirement->b1_2_solo_parent_not_cohabiting,
                    'b1_2_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->b1_2_solo_parent_not_cohabiting, $requirement->b1_2_solo_parent_not_cohabiting_expires_at, $requirement->b1_2_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Relative of OFW') {
                $requirement = $record->sprelativeofofwReq;

                $requirements = [
                    'birth_certificates_of_dependents' => $requirement->birth_certificates_of_dependents,
                    'birth_certificates_of_dependents_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_dependents, $requirement->birth_certificates_of_dependents_expires_at, $requirement->birth_certificates_of_dependents_updated_at),
                    'marriage_certificate_ofw' => $requirement->marriage_certificate_ofw,
                    'marriage_certificate_ofw_expires_at' => $getExpirationInfo($requirement->marriage_certificate_ofw, $requirement->marriage_certificate_ofw_expires_at, $requirement->marriage_certificate_ofw_updated_at),
                    'ph_overseas_employment' => $requirement->ph_overseas_employment,
                    'ph_overseas_employment_expires_at' => $getExpirationInfo($requirement->ph_overseas_employment, $requirement->ph_overseas_employment_expires_at, $requirement->ph_overseas_employment_updated_at),
                    'photocopy_of_ofw_passport' => $requirement->photocopy_of_ofw_passport,
                    'photocopy_of_ofw_passport_expires_at' => $getExpirationInfo($requirement->photocopy_of_ofw_passport, $requirement->photocopy_of_ofw_passport_expires_at, $requirement->photocopy_of_ofw_passport_updated_at),
                    'proof_of_income' => $requirement->proof_of_income,
                    'proof_of_income_expires_at' => $getExpirationInfo($requirement->proof_of_income, $requirement->proof_of_income_expires_at, $requirement->proof_of_income_updated_at),
                    'b1_2_solo_parent_not_cohabiting' => $requirement->b1_2_solo_parent_not_cohabiting,
                    'b1_2_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->b1_2_solo_parent_not_cohabiting, $requirement->b1_2_solo_parent_not_cohabiting_expires_at, $requirement->b1_2_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Unmarried person') {
                $requirement = $record->spunmarriedpersonReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'certificate_of_no_marriage' => $requirement->certificate_of_no_marriage,
                    'certificate_of_no_marriage_expires_at' => $getExpirationInfo($requirement->certificate_of_no_marriage, $requirement->certificate_of_no_marriage_expires_at, $requirement->certificate_of_no_marriage_updated_at),
                    'c_solo_parent_not_cohabiting' => $requirement->c_solo_parent_not_cohabiting,
                    'c_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->c_solo_parent_not_cohabiting, $requirement->c_solo_parent_not_cohabiting_expires_at, $requirement->c_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Legal guardian/Adoptive parent/Foster parent') {
                $requirement = $record->splegalguardianReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'proof_of_guardianship' => $requirement->proof_of_guardianship,
                    'proof_of_guardianship_expires_at' => $getExpirationInfo($requirement->proof_of_guardianship, $requirement->proof_of_guardianship_expires_at, $requirement->proof_of_guardianship_updated_at),
                    'd_solo_parent_not_cohabiting' => $requirement->d_solo_parent_not_cohabiting,
                    'd_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->d_solo_parent_not_cohabiting, $requirement->d_solo_parent_not_cohabiting_expires_at, $requirement->d_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Relative within the fourth (4th) civil degree of consanguinity or affinity') {
                $requirement = $record->sprelativeconsanguinityReq;

                $requirements = [
                    'birth_certificates_of_the_child_or_children' => $requirement->birth_certificates_of_the_child_or_children,
                    'birth_certificates_of_the_child_or_children_expires_at' => $getExpirationInfo($requirement->birth_certificates_of_the_child_or_children, $requirement->birth_certificates_of_the_child_or_children_expires_at, $requirement->birth_certificates_of_the_child_or_children_updated_at),
                    'death_cert_cert_incapacity' => $requirement->death_cert_cert_incapacity,
                    'death_cert_cert_incapacity_expires_at' => $getExpirationInfo($requirement->death_cert_cert_incapacity, $requirement->death_cert_cert_incapacity_expires_at, $requirement->death_cert_cert_incapacity_updated_at),
                    'proof_of_relationship' => $requirement->proof_of_relationship,
                    'proof_of_relationship_expires_at' => $getExpirationInfo($requirement->proof_of_relationship, $requirement->proof_of_relationship_expires_at, $requirement->proof_of_relationship_updated_at),
                    'e_solo_parent_not_cohabiting' => $requirement->e_solo_parent_not_cohabiting,
                    'e_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->e_solo_parent_not_cohabiting, $requirement->e_solo_parent_not_cohabiting_expires_at, $requirement->e_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_is_a_resident_of_the_barangay_and_child' => $requirement->solo_parent_is_a_resident_of_the_barangay_and_child,
                    'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_the_barangay_and_child, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_expires_at, $requirement->solo_parent_is_a_resident_of_the_barangay_and_child_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
                ];
            } elseif ($record->solo_parent_category === 'Pregnant woman') {
                $requirement = $record->sppregnantwomanReq;

                $requirements = [
                    'medical_record_of_pregnancy' => $requirement->medical_record_of_pregnancy,
                    'medical_record_of_pregnancy_expires_at' => $getExpirationInfo($requirement->medical_record_of_pregnancy, $requirement->medical_record_of_pregnancy_expires_at, $requirement->medical_record_of_pregnancy_updated_at),
                    'solo_parent_is_a_resident_of_barangay' => $requirement->solo_parent_is_a_resident_of_barangay,
                    'solo_parent_is_a_resident_of_barangay_expires_at' => $getExpirationInfo($requirement->solo_parent_is_a_resident_of_barangay, $requirement->solo_parent_is_a_resident_of_barangay_expires_at, $requirement->solo_parent_is_a_resident_of_barangay_updated_at),
                    'f_solo_parent_not_cohabiting' => $requirement->f_solo_parent_not_cohabiting,
                    'f_solo_parent_not_cohabiting_expires_at' => $getExpirationInfo($requirement->f_solo_parent_not_cohabiting, $requirement->f_solo_parent_not_cohabiting_expires_at, $requirement->f_solo_parent_not_cohabiting_updated_at),
                    'solo_parent_orientation_seminar_cert_of_attendance' => $requirement->solo_parent_orientation_seminar_cert_of_attendance,
                    'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => $getExpirationInfo($requirement->solo_parent_orientation_seminar_cert_of_attendance, $requirement->solo_parent_orientation_seminar_cert_of_attendance_expires_at, $requirement->solo_parent_orientation_seminar_cert_of_attendance_updated_at),
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
            'solo_parent_category' => $record->solo_parent_category,
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
