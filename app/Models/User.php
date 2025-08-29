<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'location',
        'address',
        'avatar',
        'about',
        'status',
        'admin_verified',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'admin_verified' => 'datetime',
            'password' => 'hashed',
            'location' => 'array',
        ];
    }
    protected static function booted()
    {
        static::deleting(function ($model) {
            if ($model->avatar) {
                Storage::disk('public')->delete($model->avatar);
            }
        });
    }
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }
    public static function beforeSave($record)
    {
        if ($record->isDirty('avatar')) {
            Storage::disk('public')->delete($record->getOriginal('avatar'));
        }
    }
    public function unreadMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id')
            ->where('receiver_id', auth()->id())
            ->where('is_read', false);
    }
}
