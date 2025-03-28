<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
        protected $fillable=[
            'name',
            'description',
            'price',
            'stripe_id',
            'price_id'
        ];
}
