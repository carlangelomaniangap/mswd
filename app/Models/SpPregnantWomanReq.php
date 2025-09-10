<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpPregnantWomanReq extends Model
{
    protected $fillable = [
        'solo_parent_record_id',
        'medical_record_of_pregnancy',
        'medical_record_of_pregnancy_expires_at',
        'medical_record_of_pregnancy_updated_at',
        'solo_parent_is_a_resident_of_barangay',
        'solo_parent_is_a_resident_of_barangay_expires_at',
        'solo_parent_is_a_resident_of_barangay_updated_at',
        'f_solo_parent_not_cohabiting',
        'f_solo_parent_not_cohabiting_expires_at',
        'f_solo_parent_not_cohabiting_updated_at',
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
