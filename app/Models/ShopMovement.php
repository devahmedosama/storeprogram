<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopMovement extends Model
{
    use HasFactory;
    public function items() {
        return $this->hasMany('App\Models\ShopMovementItem','shop_movement_id');
    }
    public function shop()  {
        return $this->belongsTo('App\Models\Shop','shop_id');
    }
    public function store() {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
