<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_photo',
        'bio',
        'google_id',
        'facebook_id',
        'twitter_id',
        'linkedin_id',
        'provider',
        'last_login_at',
        'signup_ip',
        'is_verified',
        'is_trusted',
        'status',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    
    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->isDirty('password')) {
                $user->password = bcrypt($user->password);
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // الأنشطة التجارية التي يملكها
    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    // التقييمات التي كتبها
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // المفضلات التي حفظها
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'favorites');
    }
}
