<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recive extends Model
{
    use HasFactory;
    public function items() {
        return $this->hasMany('App\Models\ReciveItem','recive_id');
    }
    public function purchase()  {
        return $this->belongsTo('App\Models\Purchase','purchase_id');
    }
    public function store() {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    public function suplier() {
        return $this->belongsTo('App\Models\Suplier','suplier_id');
    }
    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public static function recive_arr()  {
        $arr  =  [];
        foreach (app('request')->input('product_id') as $key => $product_id) {
            if (array_key_exists($product_id,$arr)) {
                $arr[$product_id]['recived_amount'] =  $arr[$product_id]['recived_amount'] + app('request')->input('recived_amount')[$key];
            }else{
                $arr[$product_id] = [
                    'amount'=>app('request')->input('amount')[$key],
                    'recived_amount'=>app('request')->input('recived_amount')[$key]
                ];
            }
        }
        return $arr;
    }
    
}
