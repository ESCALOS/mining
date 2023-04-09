<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concentrate extends Model
{
    use HasFactory;

    public function Orders(){
        return $this->hasMany(Order::class);
    }
}
