<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
    	return view('admin.users.edit')
    			->with('title',$data->name)
                ->with('stores',$stores)
                ->with('data',$data)
                ->with('shops',$shops)
                ->with('types',$types)
                ;
    }
    public function postEdit(Request $request,$id)
    {
    	$request->validate([
    			'image'=>'image|mimes:jpg,png,jpeg',
    			
    			]);
    	$data =  User::find($id);
    	$data->name      =  $request->name;
        $data->name_en   =  $request->name_en;
        $data->phone     =  $request->phone;
        $data->email     =  $request->email;
    	$data->save();
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
