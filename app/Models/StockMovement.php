<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;
    public function user()  {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function store()  {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    public function storeto()  {
        return $this->belongsTo('App\Models\Store','store_to');
    }
    public function items()  {
        return $this->hasMany('App\Models\StockMovementItem','stock_movement_id');
    }
}
