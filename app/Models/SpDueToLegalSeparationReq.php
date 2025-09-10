<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpDueToLegalSeparationReq extends Model
{
    protected $fillable = [
        'solo_parent_record_id',
        'birth_certificates_of_the_child_or_children',
        'birth_certificates_of_the_child_or_children_expires_at',
        'birth_certificates_of_the_child_or_children_updated_at',
        'marriage_certificate',
        'marriage_certificate_expires_at',
        'marriage_certificate_updated_at',
        'judicial_decree_of_legal_separation',
        'judicial_decree_of_legal_separation_expires_at',
        'judicial_decree_of_legal_separation_updated_at',
        'a5_solo_parent_not_cohabiting',
        'a5_solo_parent_not_cohabiting_expires_at',
        'a5_solo_parent_not_cohabiting_updated_at',
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
