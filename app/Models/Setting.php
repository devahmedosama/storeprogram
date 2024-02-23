<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public function getTitleAttribute()  {
        $lang  =  \App::getLocale();
        if ($lang  ==  'en') {
            return $this->attributes['name_en'];
        }else{
            return $this->attributes['name'];
        }
    }
}
