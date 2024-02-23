<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMovement extends Model
{
    use HasFactory;
    public static function add_action($product_id,$store_id,$amount,$link,$note,$note_en,$id,$type) {
        $data  =  new ProductMovement;
        $data->product_id =  $product_id;
        $data->store_id   =  $store_id;
        $data->user_id    =  auth()->id();
        if ($amount > 0) {
            $data->in  =  $amount;
            $data->out =  0;
        }else{
            $data->out =  abs($amount);
            $data->in  =  0;
        }
        $data->link =  $link;
        $data->note =  $note;
        $data->note_en =  $note_en;
        if ($type) {
            $data->$type = $id;
            $data->type =  $type;
        }
        // amount  added because db::commit
        $general_amount =  Stock::whereNotNull('store_id')
                                   ->where('product_id',$product_id)->sum('amount');
        $store_amount =  Stock::where('store_id',$store_id)
                          ->where('product_id',$product_id)->sum('amount');   
        if ($amount > 0 && $type =='stock_movement_item_id') {
            $data->total = $general_amount ;
        }else{
            $data->total = $general_amount + $amount;
        }                     
        
        $data->store_total = $store_amount + $amount;
        $data->save();
    }
    public function product()  {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function store()  {
        return $this->belongsTo('App\Models\Store','store_id');
    }
    public function user()  {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function getNoteAttribute()  {
        $lang  =  \App::getLocale();
        if ($lang  == 'en') {
            return $this->attributes['note_en'];
        }else{
            return $this->attributes['note'];
        }
    }
}
