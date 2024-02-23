<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public function store() {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    public function product() {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
