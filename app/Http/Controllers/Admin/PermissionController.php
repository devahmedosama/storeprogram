<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Validator;

class PermissionController extends Controller
{
    public function index()
    {
    	$allData =  Permission::OrderBy('id','desc')->paginate(30);
    	return  view('admin.permissions.index')
    				->with('allData',$allData)
    				->with('title','All permissions');
    }
    public function add()
    {
    	return view('admin.permissions.add')
    			->with('title',' Add New Permission ');
    }
    public function postAdd(Request $request)
    {
    	$validator =  Validator::make($request->all(),[
							'name'=>'required|unique:permissions'
							]);
		if ($validator->fails()) {
			return  back()
					->withErrors($validator) 
					->withInput();  
		}else{
			$data         =  new Permission;
			$data->name   =  $request->name;
			$data->slug   =  $request->slug;
			$data->save();
			return redirect('admin/permissions')
					->with('yes',' Added Successfully');
		}
    	
    }
    public function edit($id)
    {
    	$data =  Permission::find($id);
    	return view('admin.permissions.edit')
    			->with('data',$data)
    			->with('title',$data->name);
    }
    public function postEdit(Request $request,$id)
    {
    	$data =  Permission::find($id);
    	$data->name   =  $request->name;
	    $data->slug   =  $request->slug;
    	$data->save();
    	return redirect('admin/permissions')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  Permission::find($id);
    	if ($data) {
    		$data->delete();
    	}
    	return back()
    			->with('yes','Done Successfully');
    }
}
