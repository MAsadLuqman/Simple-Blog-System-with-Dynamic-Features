<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subscription extends Model
{
    protected $fillable = [
        'userId' ,
        'subscriptionId',
        'plan_price_id' ,
        'plan_amount' ,
        'plan_duration' ,
        'plan_duration_count',
        'subscriptionType' ,
        'plan-duration-start',
        'plan-duration-end',

    ];
}
