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
        'solo_parent_category',
        'emerg_first_name',
        'emerg_middle_name',
        'emerg_last_name',
        'emerg_address',
        'relationship_to_solo_parent',
        'emerg_contact_number',
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

    public function spbirthofchildconsRapeReq()
    {
        return $this->hasOne(SpBirthOfChildConsRapeReq::class, 'solo_parent_record_id');
    }

    public function spwidoworwidowerReq()
    {
        return $this->hasOne(SpWidowOrWidowerReq::class, 'solo_parent_record_id');
    }
    
    public function spspousedeprivedlibertyReq()
    {
        return $this->hasOne(SpSpouseDeprivedLibertyReq::class, 'solo_parent_record_id');
    }

    public function spspousewithpmiReq()
    {
        return $this->hasOne(SpSpouseWithPmiReq::class, 'solo_parent_record_id');
    }

    public function spduetolegalseparationReq()
    {
        return $this->hasOne(SpDueToLegalSeparationReq::class, 'solo_parent_record_id');
    }

    public function spduetoannulmentReq()
    {
        return $this->hasOne(SpDueToAnnulmentReq::class, 'solo_parent_record_id');
    }

    public function spabandonmentbyspouseReq()
    {
        return $this->hasOne(SpAbandonmentBySpouseReq::class, 'solo_parent_record_id');
    }

    public function spspouseofofwReq()
    {
        return $this->hasOne(SpSpouseOfOfwReq::class, 'solo_parent_record_id');
    }

    public function sprelativeofofwReq()
    {
        return $this->hasOne(SpRelativeOfOfwReq::class, 'solo_parent_record_id');
    }

    public function spunmarriedpersonReq()
    {
        return $this->hasOne(SpUnmarriedPersonReq::class, 'solo_parent_record_id');
    }

    public function splegalguardianReq()
    {
        return $this->hasOne(SpLegalGuardianReq::class, 'solo_parent_record_id');
    }

    public function sprelativeconsanguinityReq()
    {
        return $this->hasOne(SpRelativeConsanguinityReq::class, 'solo_parent_record_id');
    }

    public function sppregnantwomanReq()
    {
        return $this->hasOne(SpPregnantWomanReq::class, 'solo_parent_record_id');
    }

    public function soloparentfamilyMember()
    {
        return $this->hasMany(SoloParentFamilyMember::class, 'sp_record_id');
    }
}