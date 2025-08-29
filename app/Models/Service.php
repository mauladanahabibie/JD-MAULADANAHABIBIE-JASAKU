<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'mitra_id',
        'cover',
        'name',
        'price',
        'description',
        'category_id',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }
        public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }
}
