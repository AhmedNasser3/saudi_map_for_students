<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\admin\land\LandArea;
use App\Models\frontend\parents\Child;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'phone', 'password', 'balance', 'freeze_balance','level','phone_parent'

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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public static function boot()
{
    parent::boot();

    static::creating(function ($user) {
        do {
            $uniqueNumber = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (User::where('unique_number', $uniqueNumber)->exists());

        $user->unique_number = $uniqueNumber;
    });
}
public function landAreas()
{
    return $this->hasMany(LandArea::class); // علاقة One-to-Many
}

public function user(){
    return $this->belongsTo(User::class);
}

// علاقة مع الأبناء
public function children()
{
    return $this->hasMany(Child::class, 'parent_id');
}

// علاقة مع الآباء
public function parents()
{
    return $this->hasMany(Child::class, 'child_id');
}
}
