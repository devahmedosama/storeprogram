<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public static function langs()  {
        return [
            'ar'=>'العربية',
            'en'=>'English',
        ];
    }
    public static function types()  {
        return [
            '0'=>'أدمن',
            '1'=>'أمين مخزن',
            '2'=>'مدير محل',
            '3'=>'بائع',
        ];
    }
    public function getTypeNameAttribute()  {
        if (array_key_exists($this->attributes['type'],$this->types())) {
            return $this->types()[$this->attributes['type']];
        }
    }
}
