<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PwdRecord extends Model
{
    protected $fillable = [
        'photo',
        'first_name',
        'middle_name',
        'last_name',
        'house_no_unit_floor',
        'street',
        'barangay',
        'city_municipality',
        'province',
        'type_of_disability',
        'date_of_birth',
        'place_of_birth',
        'age',
        'sex',
        'civil_status',
        'blood_type',
        'educational_attainment',
        'occupation',
        'cellphone_number',
        'emerg_first_name',
        'emerg_middle_name',
        'emerg_last_name',
        'emerg_address',
        'relationship_to_pwd',
        'emerg_contact_number',
        'qr_code',
        'user_id',
        'user_role',
        'user_name',
        'updated_by',
        'updated_by_role',
        'updated_by_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pwdRequirement()
    {
        return $this->hasOne(PwdRequirement::class, 'pwd_record_id');
    }
}
