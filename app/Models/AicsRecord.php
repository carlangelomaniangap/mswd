<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AicsRecord extends Model
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
        'nature_of_problem',
        'problem_description',
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
