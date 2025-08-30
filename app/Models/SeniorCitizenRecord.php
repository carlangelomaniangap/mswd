<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeniorCitizenRecord extends Model
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
        'date_of_birth',
        'place_of_birth',
        'age',
        'sex',
        'civil_status',
        'educational_attainment',
        'occupation',
        'cellphone_number',
        'qr_code',
        'status',
        'user_id',
        'user_role',
        'user_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seniorRequirement()
    {
        return $this->hasOne(SeniorRequirement::class, 'senior_record_id');
    }

    public function seniorfamilyMember()
    {
        return $this->hasMany(SeniorFamilyMember::class, 'sc_record_id');
    }
}
