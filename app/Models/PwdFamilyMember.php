<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PwdFamilyMember extends Model
{
    protected $fillable = [
        'pwd_record_id',
        'family_member_name',
        'family_member_relationship',
        'family_member_age',
        'family_member_status',
        'user_id',
        'user_role',
        'user_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pwdRecord()
    {
        return $this->belongsTo(PwdRecord::class, 'pwd_record_id');
    }
}
