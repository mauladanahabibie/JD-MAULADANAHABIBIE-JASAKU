<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
        use HasFactory;

    protected $table = 'ratings';

    protected $fillable = [
        'order_id',
        'service_id',
        'customer_id',
        'rating',
        'review',
    ];
}
