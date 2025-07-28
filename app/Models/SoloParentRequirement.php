<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoloParentRequirement extends Model
{
    protected $fillable = [
        'solo_parent_record_id',
        'valid_id',
        'valid_id_expires_at',
        'valid_id_updated_at',
        'birth_certificate',
        'birth_certificate_expires_at',
        'birth_certificate_updated_at',
        'solo_parent_id_application_form',
        'solo_parent_id_application_form_expires_at',
        'solo_parent_id_application_form_updated_at',
        'affidavit_of_solo_parent',
        'affidavit_of_solo_parent_expires_at',
        'affidavit_of_solo_parent_updated_at',
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
