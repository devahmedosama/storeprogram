<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
    	$allData =  User::OrderBy('id','asc')->where(function($q){
            if (app('request')->input('name')) {
                $q->where('username','LIKE','%'.app('request')->input('name').'%');
            }
            if (app('request')->input('type')) {
                $q->where('type',app('request')->input('type'));
            }
        })->paginate(30);
        $types  =  \App\Models\User::types();
    	return  view('admin.users.index')
    				->with('allData',$allData)
    				->with('title',trans('home.Users'))
                    ->with('types',$types);
    }
    public function add()
    {
        $stores =  \App\Models\Store::items();
        $shops  =  \App\Models\Shop::items();
        $types  =  \App\Models\User::types();
    	return view('admin.users.add')
    			->with('title',trans('home.Add New'))
                ->with('stores',$stores)
                ->with('shops',$shops)
                ->with('types',$types)
                ;
    }
    public function postAdd(Request $request)
    {
    	$validator =  \Validator::make($request->all(),[
							'username'=>'required|unique:users'
							]); 
        $data                =  new User;
        $data->username      =  $request->username;
        $data->type          =  $request->type;
        $data->store_id      =  $request->store_id;
        $data->shop_id       =  $request->shop_id;
        $data->password      =  \Hash::make($request->password);
        $data->save();
        if ($request->ajax()) {
            return [
                'state'=>1,
                'id'=>$data->id,
                'name'=>$data->title
            ];
        }
        return redirect('admin/users')
                ->with('yes',' Added Successfully');
    	
    }
    public function edit($id)
    {
    	$data =  User::find($id);
    	$stores =  \App\Models\Store::items();
        $shops  =  \App\Models\Shop::items();
        $types  =  \App\Models\User::types();
        $permissions =  \App\Models\Permission::get();
        foreach ($permissions as $key => $item) {
           $per =  UserPermission::where('user_id',$id)
                        ->where('permission_id',$item->id)->first();
            $item->checked = $per?1:0;
            
        }
    	return view('admin.users.edit')
    			->with('title',$data->name)
                ->with('stores',$stores)
                ->with('data',$data)
                ->with('shops',$shops)
                ->with('types',$types)
                ->with('permissions',$permissions)
                ;
    }
    public function postEdit(Request $request,$id)
    {
    	$request->validate([
    			'image'=>'image|mimes:jpg,png,jpeg',
    			
    			]);
    	$data =  User::find($id);
    	$data->username      =  $request->username;
        $data->type          =  $request->type;
        $data->store_id      =  $request->store_id;
        $data->shop_id       =  $request->shop_id;
        if($request->password){
             $data->password =  \Hash::make($request->password);
        }
    	$data->save();
        UserPermission::where('user_id',$id)->delete();
        foreach ($request->permission_id as $key=>$id) {
            $per =  UserPermission::where('user_id',$data->id)
                        ->where('permission_id',$id)->first();
            $permission =  Permission::find($id);
            if (empty($per) && $permission) {
                $per =  new UserPermission;
                $per->user_id =  $data->id;
                $per->permission_id =  $id;
                $per->slug =  $permission->slug;
                $per->save();
            }
            

        }
    	return redirect('admin/users')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  User::find($id);
    	if ($data) {
    		$data->delete();
    	}
    	return back()
    			->with('yes','Done Successfully');
    }
    public function activate($id)  {
        $data  =  User::find($id);
        $data->active =  $data->active==1?0:1;
        $data->save();
        return [
            'state'=>$data->active
        ];
    }
}
