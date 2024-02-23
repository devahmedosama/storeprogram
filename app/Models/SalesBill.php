<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesBill extends Model
{
    use HasFactory;
    public function items() {
        return $this->hasMany('App\Models\SalesBillItem','sales_bill_id');
    }
    public function sales_man()  {
        return $this->belongsTo('App\Models\SalesMan','sales_man_id');
    }
    public function store() {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
