<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'service_id',
        'customer_id',
        'mitra_id',
        'description',
        'status',
        'bukti',
    ];
}
