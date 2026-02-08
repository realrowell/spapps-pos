<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_ARCHIVE = 'archive';


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'public_id',
        'username',
        'email',
        'password',
        'usr_desc',
        'role',
        'status_id',
        'full_name',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];
    public $incrementing = false;

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
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $prefix = 'usr'.date(format: 'ym');
            $model->id = IdGenerator::generate(['table' => 'users', 'length' => 20, 'prefix' => $prefix . str()->random(10)]);
        });
        static::creating(function ($model) {
            if (empty($model->public_id)) {
                $model->public_id = hash('sha256', Str::uuid());
            }
        });
    }

    public static function roleOptions(){
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_USER => 'User',
        ];
    }
    public static function statusOptions(){
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ARCHIVE => 'Archive'
        ];
    }
}
