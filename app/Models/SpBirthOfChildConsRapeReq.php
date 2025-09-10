<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpBirthOfChildConsRapeReq extends Model
{
    protected $fillable = [
        'solo_parent_record_id',
        'birth_certificates_of_the_child_or_children',
        'birth_certificates_of_the_child_or_children_expires_at',
        'birth_certificates_of_the_child_or_children_updated_at',
        'complaint_affidavit',
        'complaint_affidavit_expires_at',
        'complaint_affidavit_updated_at',
        'medical_record_on_the_incident_of_rape',
        'medical_record_on_the_incident_of_rape_expires_at',
        'medical_record_on_the_incident_of_rape_updated_at',
        'solo_parent_has_sole_parental_care_of_a_child',
        'solo_parent_has_sole_parental_care_of_a_child_expires_at',
        'solo_parent_has_sole_parental_care_of_a_child_updated_at',
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
