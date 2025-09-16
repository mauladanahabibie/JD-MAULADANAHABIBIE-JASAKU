<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    const STATUS_BELUM_BAYAR = 'belum_bayar';
    const STATUS_DIBAYAR     = 'dibayar';
    const STATUS_DIPROSES    = 'diproses';
    const STATUS_SELESAI     = 'selesai';
    const STATUS_DIBATALKAN  = 'dibatalkan';
    
    protected $table = 'orders';
    
    protected $fillable = [
        'service_id',
        'customer_id',
        'mitra_id',
        'description',
        'price',
        'status',
        'bukti',
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    
    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }
}
