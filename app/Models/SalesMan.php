<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMan extends Model
{
    use HasFactory;
    public  function getTitleAttribute(){
        $lang  =  \App::getLocale();
        if ($lang == 'ar') {
            return $this->attributes['name'];
        }else{
            return $this->attributes['name_en'];
        }
    }
    public static function items()  {
        $arr = [];
        foreach (SalesMan::get() as $data) {
            $arr[$data->id] =  $data->title;
        }
        return $arr;
    }
}
