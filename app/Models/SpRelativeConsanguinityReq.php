<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpRelativeConsanguinityReq extends Model
{
    protected $fillable = [
        'solo_parent_record_id',
        'birth_certificates_of_the_child_or_children',
        'birth_certificates_of_the_child_or_children_expires_at',
        'birth_certificates_of_the_child_or_children_updated_at',
        'death_cert_cert_incapacity',
        'death_cert_cert_incapacity_expires_at',
        'death_cert_cert_incapacity_updated_at',
        'proof_of_relationship',
        'proof_of_relationship_expires_at',
        'proof_of_relationship_updated_at',
        'e_solo_parent_not_cohabiting',
        'e_solo_parent_not_cohabiting_expires_at',
        'e_solo_parent_not_cohabiting_updated_at',
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
