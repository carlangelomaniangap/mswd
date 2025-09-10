<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpAbandonmentBySpouseReq extends Model
{
    protected $fillable = [
        'solo_parent_record_id',
        'birth_certificates_of_the_child_or_children',
        'birth_certificates_of_the_child_or_children_expires_at',
        'birth_certificates_of_the_child_or_children_updated_at',
        'marriage_certificate_affidavit',
        'marriage_certificate_affidavit_expires_at',
        'marriage_certificate_affidavit_updated_at',
        'abandonment_of_the_spouse',
        'abandonment_of_the_spouse_expires_at',
        'abandonment_of_the_spouse_updated_at',
        'record_of_the_fact_of_abandonment',
        'record_of_the_fact_of_abandonment_expires_at',
        'record_of_the_fact_of_abandonment_updated_at',
        'a7_solo_parent_not_cohabiting',
        'a7_solo_parent_not_cohabiting_expires_at',
        'a7_solo_parent_not_cohabiting_updated_at',
        'solo_parent_is_a_resident',
        'solo_parent_is_a_resident_expires_at',
        'solo_parent_is_a_resident_updated_at',
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
