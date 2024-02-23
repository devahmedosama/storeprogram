<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    public static function ways()  {
        return [
            0=>trans('home.E-mail'),
            1=>trans('home.WhatsApp')
        ];
    }
    public function supplier()  {
        return $this->belongsTo('App\Models\Suplier','suplier_id');
    }
    public function getStatusAttribute()  {
        $states = [
                    0=>trans('home.Not Recived'),
                    1=>trans('home.partial Recived'),
                    2=>trans('home.Recived'),
                ];
        $state =  $this->attributes['state'];
        if (array_key_exists($state,$states)) {
            return $states[$state];
        }
    }
    public function items() {
        return $this->hasMany('App\Models\PurchaseItem','purchase_id');
    }
    public function recive()  {
        return $this->hasOne('App\Models\Recive','purchase_id');
    }
}
