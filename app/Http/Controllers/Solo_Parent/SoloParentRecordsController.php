<?php

namespace App\Http\Controllers\Solo_Parent;

use App\Http\Controllers\Controller;
use App\Models\SoloParentRecord;
use App\Models\SpAbandonmentBySpouseReq;
use App\Models\SpBirthOfChildConsRapeReq;
use App\Models\SpDueToAnnulmentReq;
use App\Models\SpLegalGuardianReq;
use App\Models\SpPregnantWomanReq;
use App\Models\SpRelativeConsanguinityReq;
use App\Models\SpRelativeOfOfwReq;
use App\Models\SpSpouseDeprivedLibertyReq;
use App\Models\SpDueToLegalSeparationReq;
use App\Models\SpSpouseOfOfwReq;
use App\Models\SpSpouseWithPmiReq;
use App\Models\SpUnmarriedPersonReq;
use App\Models\SpWidowOrWidowerReq;
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
            'solo_parent_category' => 'required|in:Birth of a child as a consequence of rape,Widow/widower,Spouse of person deprived of liberty,Spouse of person with physical or mental incapacity,Due to legal separation or de facto separation,Due to nullity or annulment of marriage,Abandonment by the spouse,Spouse of OFW,Relative of OFW,Unmarried person,Legal guardian/Adoptive parent/Foster parent,Relative within the fourth (4th) civil degree of consanguinity or affinity,Pregnant woman',
            'emerg_first_name' => 'required|string|max:255',
            'emerg_middle_name' => 'nullable|string|max:255',
            'emerg_last_name' => 'required|string|max:255',
            'emerg_address' => 'required|string|max:255',
            'relationship_to_solo_parent' => 'required|string|max:255',
            'emerg_contact_number' => 'required|string|regex:/^09\d{9}$/',
        ]);

        // Check if a beneficiary with the same first name, last name, and date of birth already exists
        $existing = SoloParentRecord::where('first_name', $validated['first_name'])
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

        $nextId = SoloParentRecord::max('id') + 1;
        $formattedId = str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $qr_code = "qr_solo_parent_{$formattedId}.svg";

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
            'solo_parent_category' => $validated['solo_parent_category'],
            'emerg_first_name' => $validated['emerg_first_name'],
            'emerg_middle_name' => $validated['emerg_middle_name'] ?? null,
            'emerg_last_name' => $validated['emerg_last_name'],
            'emerg_address' => $validated['emerg_address'],
            'relationship_to_solo_parent' => $validated['relationship_to_solo_parent'],
            'emerg_contact_number' => $validated['emerg_contact_number'],
            'qr_code' =>  $qr_code,
            'status'=> 'In Progress',
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name
        ]);

        $qrText = url("/solo_parent/record/data/scan?qrcode=" . 'SP-' . str_pad($record->id, 3, '0', STR_PAD_LEFT));
        $qrPath = public_path("qrcodes/{$qr_code}");

        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        QrCode::format('svg')->size(200)->generate($qrText, $qrPath);

        if($record->solo_parent_category === 'Birth of a child as a consequence of rape') {
            SpBirthOfChildConsRapeReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'complaint_affidavit' => 'Incomplete',
                'complaint_affidavit_expires_at' => null,
                'complaint_affidavit_updated_at' => null,
                'medical_record_on_the_incident_of_rape' => 'Incomplete',
                'medical_record_on_the_incident_of_rape_expires_at' => null,
                'medical_record_on_the_incident_of_rape_updated_at' => null,
                'solo_parent_has_sole_parental_care_of_a_child' => 'Incomplete',
                'solo_parent_has_sole_parental_care_of_a_child_expires_at' => null,
                'solo_parent_has_sole_parental_care_of_a_child_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Widow/widower') {
            SpWidowOrWidowerReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'marriage_certificate' => 'Incomplete',
                'marriage_certificate_expires_at' => null,
                'marriage_certificate_updated_at' => null,
                'death_certificate_of_the_spouse' => 'Incomplete',
                'death_certificate_of_the_spouse_expires_at' => null,
                'death_certificate_of_the_spouse_updated_at' => null,
                'a2_solo_parent_not_cohabiting' => 'Incomplete',
                'a2_solo_parent_not_cohabiting_expires_at' => null,
                'a2_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Spouse of person deprived of liberty') {
            SpSpouseDeprivedLibertyReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'marriage_certificate' => 'Incomplete',
                'marriage_certificate_expires_at' => null,
                'marriage_certificate_updated_at' => null,
                'certificate_of_detention' => 'Incomplete',
                'certificate_of_detention_expires_at' => null,
                'certificate_of_detention_updated_at' => null,
                'a3_solo_parent_not_cohabiting' => 'Incomplete',
                'a3_solo_parent_not_cohabiting_expires_at' => null,
                'a3_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Spouse of person with physical or mental incapacity') {
            SpSpouseWithPmiReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'marriage_cert_or_affidavit_of_cohabitation' => 'Incomplete',
                'marriage_cert_or_affidavit_of_cohabitation_expires_at' => null,
                'marriage_cert_or_affidavit_of_cohabitation_updated_at' => null,
                'med_record_med_abstract_or_cert_of_confinement' => 'Incomplete',
                'med_record_med_abstract_or_cert_of_confinement_expires_at' => null,
                'med_record_med_abstract_or_cert_of_confinement_updated_at' => null,
                'a4_solo_parent_not_cohabiting' => 'Incomplete',
                'a4_solo_parent_not_cohabiting_expires_at' => null,
                'a4_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Due to legal separation or de facto separation') {
            SpDueToLegalSeparationReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'marriage_certificate' => 'Incomplete',
                'marriage_certificate_expires_at' => null,
                'marriage_certificate_updated_at' => null,
                'judicial_decree_of_legal_separation' => 'Incomplete',
                'judicial_decree_of_legal_separation_expires_at' => null,
                'judicial_decree_of_legal_separation_updated_at' => null,
                'a5_solo_parent_not_cohabiting' => 'Incomplete',
                'a5_solo_parent_not_cohabiting_expires_at' => null,
                'a5_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Due to nullity or annulment of marriage') {
            SpDueToAnnulmentReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'marriage_certificate_nullity' => 'Incomplete',
                'marriage_certificate_nullity_expires_at' => null,
                'marriage_certificate_nullity_updated_at' => null,
                'judicial_decree_of_nullity' => 'Incomplete',
                'judicial_decree_of_nullity_expires_at' => null,
                'judicial_decree_of_nullity_updated_at' => null,
                'a6_solo_parent_not_cohabiting' => 'Incomplete',
                'a6_solo_parent_not_cohabiting_expires_at' => null,
                'a6_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Abandonment by the spouse') {
            SpAbandonmentBySpouseReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'marriage_certificate_affidavit' => 'Incomplete',
                'marriage_certificate_affidavit_expires_at' => null,
                'marriage_certificate_affidavit_updated_at' => null,
                'abandonment_of_the_spouse' => 'Incomplete',
                'abandonment_of_the_spouse_expires_at' => null,
                'abandonment_of_the_spouse_updated_at' => null,
                'record_of_the_fact_of_abandonment' => 'Incomplete',
                'record_of_the_fact_of_abandonment_expires_at' => null,
                'record_of_the_fact_of_abandonment_updated_at' => null,
                'a7_solo_parent_not_cohabiting' => 'Incomplete',
                'a7_solo_parent_not_cohabiting_expires_at' => null,
                'a7_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident' => 'Incomplete',
                'solo_parent_is_a_resident_expires_at' => null,
                'solo_parent_is_a_resident_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Spouse of OFW') {
            SpSpouseOfOfwReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_dependents' => 'Incomplete',
                'birth_certificates_of_dependents_expires_at' => null,
                'birth_certificates_of_dependents_updated_at' => null,
                'marriage_certificate_ofw' => 'Incomplete',
                'marriage_certificate_ofw_expires_at' => null,
                'marriage_certificate_ofw_updated_at' => null,
                'ph_overseas_employment' => 'Incomplete',
                'ph_overseas_employment_expires_at' => null,
                'ph_overseas_employment_updated_at' => null,
                'photocopy_of_ofw_passport' => 'Incomplete',
                'photocopy_of_ofw_passport_expires_at' => null,
                'photocopy_of_ofw_passport_updated_at' => null,
                'proof_of_income' => 'Incomplete',
                'proof_of_income_expires_at' => null,
                'proof_of_income_updated_at' => null,
                'b1_2_solo_parent_not_cohabiting' => 'Incomplete',
                'b1_2_solo_parent_not_cohabiting_expires_at' => null,
                'b1_2_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Relative of OFW') {
            SpRelativeOfOfwReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_dependents' => 'Incomplete',
                'birth_certificates_of_dependents_expires_at' => null,
                'birth_certificates_of_dependents_updated_at' => null,
                'marriage_certificate_ofw' => 'Incomplete',
                'marriage_certificate_ofw_expires_at' => null,
                'marriage_certificate_ofw_updated_at' => null,
                'ph_overseas_employment' => 'Incomplete',
                'ph_overseas_employment_expires_at' => null,
                'ph_overseas_employment_updated_at' => null,
                'photocopy_of_ofw_passport' => 'Incomplete',
                'photocopy_of_ofw_passport_expires_at' => null,
                'photocopy_of_ofw_passport_updated_at' => null,
                'proof_of_income' => 'Incomplete',
                'proof_of_income_expires_at' => null,
                'proof_of_income_updated_at' => null,
                'b1_2_solo_parent_not_cohabiting' => 'Incomplete',
                'b1_2_solo_parent_not_cohabiting_expires_at' => null,
                'b1_2_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Unmarried person') {
            SpUnmarriedPersonReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'certificate_of_no_marriage' => 'Incomplete',
                'certificate_of_no_marriage_expires_at' => null,
                'certificate_of_no_marriage_updated_at' => null,
                'c_solo_parent_not_cohabiting' => 'Incomplete',
                'c_solo_parent_not_cohabiting_expires_at' => null,
                'c_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Legal guardian/Adoptive parent/Foster parent') {
            SpLegalGuardianReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'proof_of_guardianship' => 'Incomplete',
                'proof_of_guardianship_expires_at' => null,
                'proof_of_guardianship_updated_at' => null,
                'd_solo_parent_not_cohabiting' => 'Incomplete',
                'd_solo_parent_not_cohabiting_expires_at' => null,
                'd_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Relative within the fourth (4th) civil degree of consanguinity or affinity') {
            SpRelativeConsanguinityReq::create([
                'solo_parent_record_id' => $record->id,
                'birth_certificates_of_the_child_or_children' => 'Incomplete',
                'birth_certificates_of_the_child_or_children_expires_at' => null,
                'birth_certificates_of_the_child_or_children_updated_at' => null,
                'death_cert_cert_incapacity' => 'Incomplete',
                'death_cert_cert_incapacity_expires_at' => null,
                'death_cert_cert_incapacity_updated_at' => null,
                'proof_of_relationship' => 'Incomplete',
                'proof_of_relationship_expires_at' => null,
                'proof_of_relationship_updated_at' => null,
                'e_solo_parent_not_cohabiting' => 'Incomplete',
                'e_solo_parent_not_cohabiting_expires_at' => null,
                'e_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'Incomplete',
                'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at' => null,
                'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
        } elseif($record->solo_parent_category === 'Pregnant woman') {
            SpPregnantWomanReq::create([
                'solo_parent_record_id' => $record->id,
                'medical_record_of_pregnancy' => 'Incomplete',
                'medical_record_of_pregnancy_expires_at' => null,
                'medical_record_of_pregnancy_updated_at' => null,
                'solo_parent_is_a_resident_of_barangay' => 'Incomplete',
                'solo_parent_is_a_resident_of_barangay_expires_at' => null,
                'solo_parent_is_a_resident_of_barangay_updated_at' => null,
                'f_solo_parent_not_cohabiting' => 'Incomplete',
                'f_solo_parent_not_cohabiting_expires_at' => null,
                'f_solo_parent_not_cohabiting_updated_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance' => 'Incomplete',
                'solo_parent_orientation_seminar_cert_of_attendance_expires_at' => null,
                'solo_parent_orientation_seminar_cert_of_attendance_updated_at' => null,
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
            ]);
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
            SpBirthOfChildConsRapeReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'complaint_affidavit' => 'complaint_affidavit_expires_at',
                'medical_record_on_the_incident_of_rape' => 'medical_record_on_the_incident_of_rape_expires_at',
                'solo_parent_has_sole_parental_care_of_a_child' => 'solo_parent_has_sole_parental_care_of_a_child_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpWidowOrWidowerReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'marriage_certificate' => 'marriage_certificate_expires_at',
                'death_certificate_of_the_spouse' => 'death_certificate_of_the_spouse_expires_at',
                'a2_solo_parent_not_cohabiting' => 'a2_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpSpouseDeprivedLibertyReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'marriage_certificate' => 'marriage_certificate_expires_at',
                'certificate_of_detention' => 'certificate_of_detention_expires_at',
                'a3_solo_parent_not_cohabiting' => 'a3_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpSpouseWithPmiReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'marriage_cert_or_affidavit_of_cohabitation' => 'marriage_cert_or_affidavit_of_cohabitation_expires_at',
                'med_record_med_abstract_or_cert_of_confinement' => 'med_record_med_abstract_or_cert_of_confinement_expires_at',
                'a4_solo_parent_not_cohabiting' => 'a4_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpDueToLegalSeparationReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'marriage_certificate' => 'marriage_certificate_expires_at',
                'judicial_decree_of_legal_separation' => 'judicial_decree_of_legal_separation_expires_at',
                'a5_solo_parent_not_cohabiting' => 'a5_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpDueToAnnulmentReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'marriage_certificate_nullity' => 'marriage_certificate_nullity_expires_at',
                'judicial_decree_of_nullity' => 'judicial_decree_of_nullity_expires_at',
                'a6_solo_parent_not_cohabiting' => 'a6_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpAbandonmentBySpouseReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'marriage_certificate_affidavit' => 'marriage_certificate_affidavit_expires_at',
                'abandonment_of_the_spouse' => 'abandonment_of_the_spouse_expires_at',
                'record_of_the_fact_of_abandonment' => 'record_of_the_fact_of_abandonment_expires_at',
                'a7_solo_parent_not_cohabiting' => 'a7_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident' => 'solo_parent_is_a_resident_expires_at',
            ],
            SpSpouseOfOfwReq::class => [
                'birth_certificates_of_dependents' => 'birth_certificates_of_dependents_expires_at',
                'marriage_certificate_ofw' => 'marriage_certificate_ofw_expires_at',
                'ph_overseas_employment' => 'ph_overseas_employment_expires_at',
                'photocopy_of_ofw_passport' => 'photocopy_of_ofw_passport_expires_at',
                'proof_of_income' => 'proof_of_income_expires_at',
                'b1_2_solo_parent_not_cohabiting' => 'b1_2_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpRelativeOfOfwReq::class => [
                'birth_certificates_of_dependents' => 'birth_certificates_of_dependents_expires_at',
                'marriage_certificate_ofw' => 'marriage_certificate_ofw_expires_at',
                'ph_overseas_employment' => 'ph_overseas_employment_expires_at',
                'photocopy_of_ofw_passport' => 'photocopy_of_ofw_passport_expires_at',
                'proof_of_income' => 'proof_of_income_expires_at',
                'b1_2_solo_parent_not_cohabiting' => 'b1_2_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpUnmarriedPersonReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'certificate_of_no_marriage' => 'certificate_of_no_marriage_expires_at',
                'c_solo_parent_not_cohabiting' => 'c_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpLegalGuardianReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'proof_of_guardianship' => 'proof_of_guardianship_expires_at',
                'd_solo_parent_not_cohabiting' => 'd_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpRelativeConsanguinityReq::class => [
                'birth_certificates_of_the_child_or_children' => 'birth_certificates_of_the_child_or_children_expires_at',
                'death_cert_cert_incapacity' => 'death_cert_cert_incapacity_expires_at',
                'proof_of_relationship' => 'proof_of_relationship_expires_at',
                'e_solo_parent_not_cohabiting' => 'e_solo_parent_not_cohabiting_expires_at',
                'solo_parent_is_a_resident_of_the_barangay_and_child' => 'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
            SpPregnantWomanReq::class => [
                'medical_record_of_pregnancy' => 'medical_record_of_pregnancy_expires_at',
                'solo_parent_is_a_resident_of_barangay' => 'solo_parent_is_a_resident_of_barangay_expires_at',
                'f_solo_parent_not_cohabiting' => 'f_solo_parent_not_cohabiting_expires_at',
                'solo_parent_orientation_seminar_cert_of_attendance' => 'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
            ],
        ];

        foreach ($models as $model => $columns) {
            foreach ($columns as $column => $expiresAt) {
                $expiredRequirements = $model::where($expiresAt, '<=', $now)
                    ->where($column, '!=', 'Renewal')
                    ->get();

                foreach ($expiredRequirements as $req) {
                    $req->update([$column => 'Renewal']);

                    $record = $req->soloParentRecord;
                    if ($record) {
                        $record->status = 'Expired';
                        $record->save();
                    }
                }
            }
        }

        $records = SoloParentRecord::with([
            'spbirthofchildconsRapeReq',
            'spwidoworwidowerReq',
            'spspousedeprivedlibertyReq',
            'spspousewithpmiReq',
            'spduetolegalseparationReq',
            'spduetoannulmentReq',
            'spabandonmentbyspouseReq',
            'spspouseofofwReq',
            'sprelativeofofwReq',
            'spunmarriedpersonReq',
            'splegalguardianReq',
            'sprelativeconsanguinityReq',
            'sppregnantwomanReq',
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
                'religion' => $record->religion,
                'philsys_card_number' => $record->philsys_card_number,
                'educational_attainment' => $record->educational_attainment,
                'occupation' => $record->occupation,
                'company_agency' => $record->company_agency,
                'monthly_income' => $record->monthly_income,
                'pantawid_beneficiary' => $record->pantawid_beneficiary,
                'household_id' => $record->household_id,
                'indigenous_person' => $record->indigenous_person,
                'name_of_affliation' => $record->name_of_affliation,
                'solo_parent_category' => $record->solo_parent_category,
                'emerg_first_name' => $record->emerg_first_name,
                'emerg_last_name' => $record->emerg_last_name,
                'emerg_address' => $record->emerg_address,
                'relationship_to_solo_parent' => $record->relationship_to_solo_parent,
                'emerg_contact_number' => $record->emerg_contact_number,
                'qr_code' => $qr_code,
                'created_at' => $record->created_at->format('F j, Y'),

                // For DataTable display
                'name' => $record->last_name . ', ' . $record->first_name,
                'address' => $record->barangay . ', ' . $record->city_municipality . ', ' . $record->province,
                'sex' => $record->sex,
                'cellphone_number' => $record->cellphone_number,
                'sp_id' => '<span class="text-sm text-white bg-blue-500 rounded-full px-2 py-1">SP-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) . '</span>',
                'number_of_children' => $record->number_of_children,
                'employment_status' => $record->employment_status,
                'status' => $status,

                // requirement
                'requirements' => $requirements,
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function print(Request $request)
    {
        // get the id from the url query
        $id = $request->query('id');

        // separate id to type and recordID
        [$type, $recordID] = explode('-', $id);

        // convert recordID to integer
        $recordID = (int)$recordID;

        if ($type === 'SP') {
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

        $data = [
            'photo' => $photo,
            'name' => $record->last_name . ', ' . $record->first_name,
            'sp_id' => 'SP-' . str_pad($record->id, 3, '0', STR_PAD_LEFT),
            'address' => $record->barangay . ', ' . $record->city_municipality . ', ' . $record->province,
            'sex' => $record->sex,
            'cellphone_number' => $record->cellphone_number,
            'date_of_birth' => date('F j, Y', strtotime($record->date_of_birth)),
            'age' => $record->age,
            'qr_code' => $qr_code,
        ];

        return view('pages.admin.print_id_card', [
            'data' => $data,
            'type' => $type
        ]);
    }
}