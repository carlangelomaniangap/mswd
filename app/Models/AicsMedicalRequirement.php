<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AicsMedicalRequirement extends Model
{
    protected $fillable = [
        'aics_record_id',
        'letter_to_the_mayor',
        'letter_to_the_mayor_expires_at',
        'letter_to_the_mayor_updated_at',
        'medical_certficate',
        'medical_certificate_expires_at',
        'medical_certificate_updated_at',
        'laboratory_or_prescription',
        'laboratory_or_prescription_expires_at',
        'laboratory_or_prescription_updated_at',
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
