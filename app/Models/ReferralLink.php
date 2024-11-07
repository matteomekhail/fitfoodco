<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralLink extends Model
{
    protected $fillable = [
        'code',
        'stripe_account_id',
        'trainer_name',
        'trainer_email'
    ];


}
