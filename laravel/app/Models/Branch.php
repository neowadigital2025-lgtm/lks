<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';
    protected $fillable = ['name','slug'];

    public function rooms(){
        return $this->hasMany(Room::class,'branch_id');
    }
}
