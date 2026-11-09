<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;   
use Laravel\Sanctum\HasApiTokens; // REVISI: Penulisan Sanctum yang benar

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Tambahkan trait bawaan agar tidak eror

    protected $table = 'users'; // Mengunci nama tabel database secara aman

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
