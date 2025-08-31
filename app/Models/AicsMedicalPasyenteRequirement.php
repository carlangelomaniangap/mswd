<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AicsMedicalPasyenteRequirement extends Model
{
    protected $fillable = [
        'aics_record_id',
        'personal_letter',
        'personal_letter_expires_at',
        'personal_letter_updated_at',
        'brgy_cert_of_indigency',
        'brgy_cert_of_indigency_expires_at',
        'brgy_cert_of_indigency_updated_at',
        'medical_abstract_or_medical_certificate',
        'medical_abstract_or_medical_certificate_expires_at',
        'medical_abstract_or_medical_certificate_updated_at',
        'latest_na_reseta_with_costing',
        'latest_na_reseta_with_costing_expires_at',
        'latest_na_reseta_with_costing_updated_at',
        'latest_na_laboratory_test_with_costing',
        'latest_na_laboratory_test_with_costing_expires_at',
        'latest_na_laboratory_test_with_costing_updated_at',
        'hospital_bill',
        'hospital_bill_expires_at',
        'hospital_bill_updated_at',
        'one_valid_id',
        'one_valid_id_expires_at',
        'one_valid_id_updated_at',
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
