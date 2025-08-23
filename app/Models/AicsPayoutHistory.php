<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AicsPayoutHistory extends Model
{
    protected $fillable = [
        'aics_record_id_payout',
        'amount',
        'type',
        'claimed_by',
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
        return $this->belongsTo(AicsRecord::class, 'aics_record_id_payout');
    }
}
