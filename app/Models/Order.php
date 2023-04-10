<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function Client(){
        return $this->belongsTo(Entity::class,'client_id');
    }

    public function Concentrate(){
        return $this->belongsTo(Concentrate::class);
    }
}
