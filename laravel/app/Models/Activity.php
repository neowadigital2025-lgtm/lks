<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // REVISI: Namespace HasFactory yang benar
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id', 'name', 'duration'
    ];

    // Relasi ke User (Organizer)
    public function organizer()
    {
        // REVISI: belongsTo (T kapital) dan menggunakan kolom 'organizer_id' sesuai DB soal
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relasi ke banyak Schedule
    public function schedules() // REVISI: Sebaiknya gunakan nama jamak (schedules) karena hasMany
    {
        return $this->hasMany(Schedule::class, 'activity_id');
    }
}
