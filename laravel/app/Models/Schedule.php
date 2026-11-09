<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','room_id','activity_id','start_at',
        'end_at','price'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    // relasi ruangan 
    public function romm(){
        return $this->belongsTo(Room::class,'room_id');
    }

    // Relasi jadwal
    public function activity(){
        return $this->belongsTo(Activity::class,'activity_id');
    }
}
