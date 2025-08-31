<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AicsBurialRequirement extends Model
{
    protected $fillable = [
        'aics_record_id',
        'brgy_cert_of_indigency',
        'brgy_cert_of_indigency_expires_at',
        'brgy_cert_of_indigency_updated_at',
        'death_certificate',
        'death_certificate_expires_at',
        'death_certificate_updated_at',
        'proof_of_billing_or_promissory_note_from_funeral',
        'proof_of_billing_or_promissory_note_from_funeral_expires_at',
        'proof_of_billing_or_promissory_note_from_funeral_updated_at',
        'marriage_cert_or_birth_cert_or_cert_of_cohabitation',
        'marriage_cert_or_birth_cert_or_cert_of_cohabitation_expires_at',
        'marriage_cert_or_birth_cert_or_cert_of_cohabitation_updated_at',
        'photocopy_of_valid_id',
        'photocopy_of_valid_id_expires_at',
        'photocopy_of_valid_id_updated_at',
        'surrender_id',
        'surrender_id_expires_at',
        'surrender_id_updated_at',
        'personal_letter',
        'personal_letter_expires_at',
        'personal_letter_updated_at',
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
