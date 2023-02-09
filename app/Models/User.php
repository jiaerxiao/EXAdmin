<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $with = ['roles', 'permissions'];

    protected $fillable = ['avatar', 'number', 'name', 'real_name', 'email',  'mobile', 'sex'];

    protected $hidden = ['password',  'remember_token',  'unionid',  'openid', 'miniapp_openid',];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function avatar(): Attribute
    {
        return new Attribute(get: fn ($value) => asset($value));
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where('name', 'like', '%' . $search . '%')->orWhere('number', 'like', '%' . $search . '%')
            )
        );

        $query->when(
            json_decode($filters['filters']) ?? false,
            fn ($query, $filters) => array_walk($filters, fn ($value, $key) => $query->whereIn($key, $value))
        );
    }
}
