<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpRelativeOfOfwReq extends Model
{
    protected $fillable = [
        'solo_parent_record_id',
        'birth_certificates_of_dependents',
        'birth_certificates_of_dependents_expires_at',
        'birth_certificates_of_dependents_updated_at',
        'marriage_certificate_ofw',
        'marriage_certificate_ofw_expires_at',
        'marriage_certificate_ofw_updated_at',
        'ph_overseas_employment',
        'ph_overseas_employment_expires_at',
        'ph_overseas_employment_updated_at',
        'photocopy_of_ofw_passport',
        'photocopy_of_ofw_passport_expires_at',
        'photocopy_of_ofw_passport_updated_at',
        'proof_of_income',
        'proof_of_income_expires_at',
        'proof_of_income_updated_at',
        'b1_2_solo_parent_not_cohabiting',
        'b1_2_solo_parent_not_cohabiting_expires_at',
        'b1_2_solo_parent_not_cohabiting_updated_at',
        'solo_parent_is_a_resident_of_the_barangay_and_child',
        'solo_parent_is_a_resident_of_the_barangay_and_child_expires_at',
        'solo_parent_is_a_resident_of_the_barangay_and_child_updated_at',
        'solo_parent_orientation_seminar_cert_of_attendance',
        'solo_parent_orientation_seminar_cert_of_attendance_expires_at',
        'solo_parent_orientation_seminar_cert_of_attendance_updated_at',
        'user_id',
        'user_role',
        'user_name'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function soloParentRecord()
    {
        return $this->belongsTo(SoloParentRecord::class, 'solo_parent_record_id');
    }
}
