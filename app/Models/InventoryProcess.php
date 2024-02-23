<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryProcess extends Model
{
    use HasFactory;
    public function items()  {
        return $this->hasMany('App\Models\Inventory','inventory_process_id');
    }
    public function user()  {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
