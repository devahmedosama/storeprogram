<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
    protected $appends = ['title'];
    use HasFactory;
    public  function getTitleAttribute(){
        $lang  =  \App::getLocale();
        if ($lang == 'ar') {
            return $this->attributes['name'];
        }else{
            return $this->attributes['name_en'];
        }
    }
}
