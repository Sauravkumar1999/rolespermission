<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Plank\Mediable\Mediable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Mediable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['google_id', 'name', 'email', 'phone', 'profile', 'status', 'password', 'email_verified_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function directMessages(): HasMany
    {
        return $this->hasMany(DirectMessage::class, 'user_one_id')
            ->orWhere('user_two_id', $this->id);
    }

    /**
     * Get all chat messages sent by the user.
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }
}
