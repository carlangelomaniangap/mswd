<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AicsFamilyMember extends Model
{
    protected $fillable = [
        'aics_record_id',
        'family_member_name',
        'relationship',
        'family_member_age',
        'family_member_civil_status',
        'family_member_educational_attainment',
        'family_member_occupation',
        'family_member_monthly_income',
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
