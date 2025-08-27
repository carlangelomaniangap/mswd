<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AicsBurialRequirement extends Model
{
    protected $fillable = [
        'aics_record_id',
        'letter_to_the_mayor',
        'letter_to_the_mayor_expires_at',
        'letter_to_the_mayor_updated_at',
        'death_certificate',
        'death_certificate_expires_at',
        'death_certificate_updated_at',
        'funeral_contract',
        'funeral_contract_expires_at',
        'funeral_contract_updated_at',
        'barangay_indigency',
        'barangay_indigency_expires_at',
        'barangay_indigency_updated_at',
        'valid_id',
        'valid_id_expires_at',
        'valid_id_updated_at',
        'cedula',
        'cedula_expires_at',
        'cedula_updated_at',
        'barangay_certificate_or_marriage_contract',
        'barangay_certificate_or_marriage_contract_expires_at',
        'barangay_certificate_or_marriage_contract_updated_at',
        'user_id',
        'user_role',
        'user_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aicsRecord()
    {
        return $this->belongsTo(AicsRecord::class, 'aics_record_id');
    }
}
