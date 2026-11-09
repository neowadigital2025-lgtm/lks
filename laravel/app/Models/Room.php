<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id','name','base_price','additional_friday_price','additional_saturday_price',
        'additional_monday_price'
    ];

    public function branch(){
        return $this->belongsto(Branch::class,'branch_id');
    }
}
