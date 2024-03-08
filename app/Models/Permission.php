<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public static function check_permission($slug)  {
        $ch =  Permission::where('slug',$slug)
                   ->first();
        $state =  1;
        if ($ch && auth()->user()->type !=0 ) {
            $per =  UserPermission::where('permission_id',$ch->id)
                        ->where('user_id',auth()->id())->first();
            if (empty($per)) {
               $state =  0;
            }
        }
        return $state;
    }
}
