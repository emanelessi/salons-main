<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;
    public function SalonSeats(){
        return $this->hasMany(SalonSeat::class,'salon_id','id');
    }
    public function Users(){
        return $this->belongsToMany(User::class, 'requests');
    }
    public function Requests(){
        return $this->hasMany(Request::class, 'salon_id');
    }
}
