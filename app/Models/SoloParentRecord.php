<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoloParentRecord extends Model
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
        'religion',
        'philsys_card_number',
        'educational_attainment',
        'employment_status',
        'occupation',
        'company_agency',
        'monthly_income',
        'cellphone_number',
        'number_of_children',
        'pantawid_beneficiary',
        'household_id',
        'indigenous_person',
        'name_of_affliation',
        'emerg_first_name',
        'emerg_middle_name',
        'emerg_last_name',
        'emerg_address',
        'relationship_to_solo_parent',
        'emerg_contact_number',
        'qr_code',
        'user_id',
        'user_role',
        'user_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
