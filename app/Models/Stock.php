<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    public static function update_stock($id,$store_id,$amount)  {
        //update store stock
        $data  =  Stock::where('store_id',$store_id)->where('product_id',$id)->first();
        if (empty($data)) {
            $data             =  new Stock;
            $data->store_id   = $store_id;
            $data->product_id = $id;
            $data->amount     =  $amount;
            $data->save();
        }else{
            $data->amount  =  $data->amount + $amount;
            $data->save();
        }
        $general        =  Stock::whereNull('store_id')->where('product_id',$id)->first();
        $general_amount =  Stock::whereNotNull('store_id')
                                   ->where('product_id',$id)->sum('amount');
        if (empty($general)) {
            $general =  new Stock;
        }
        $general->amount =  $general_amount;
        $general->product_id =  $id;
        $general->save();
    }
    public  static function update_movement($id,$store_from,$store_to,$amount) {
        // stock-move to
        $data  =  Stock::where('store_id',$store_to)->where('product_id',$id)->first();
        if (empty($data)) {
            $data             =  new Stock;
            $data->store_id   = $store_to;
            $data->product_id = $id;
            $data->amount     =  $amount;
            $data->save();
        }else{
            $data->amount  =  $data->amount + $amount;
            $data->save();
        }
        // stock move form
        $data =   Stock::where('store_id',$store_from)->where('product_id',$id)->first();
        if (empty($data)) {
             $data  = new Stock;
             $data->store_id  = $store_from;
             $data->product_id =  $id;
             $data->amount  =  0;
        }
        $data->amount  =  $data->amount - $amount;
        $data->save();


    }
    public function product()  {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function store()  {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    
}
