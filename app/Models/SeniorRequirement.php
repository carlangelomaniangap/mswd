<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeniorRequirement extends Model
{
    protected $fillable = [
        'senior_record_id',
        'valid_id',
        'valid_id_expires_at',
        'valid_id_updated_at',
        'birth_certificate',
        'birth_certificate_expires_at',
        'birth_certificate_updated_at',
        'barangay_certificate',
        'barangay_certificate_expires_at',
        'barangay_certificate_updated_at',
        'user_id',
        'user_role',
        'user_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seniorCitizenRecord()
    {
        return $this->belongsTo(SeniorCitizenRecord::class, 'senior_record_id');
    }
}
