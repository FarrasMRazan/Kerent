<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'shop_name',
        'shop_address',
        'shop_logo',
        'address', 
        'latitude',
        'longitude'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // GUNAKAN SATU SAJA DAN HARUS PUBLIC
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class, 'user_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
}