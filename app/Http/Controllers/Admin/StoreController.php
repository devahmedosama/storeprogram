<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
    	$allData =  Store::OrderBy('id','desc')->paginate(30);
    	return  view('admin.stores.index')
    				->with('allData',$allData)
    				->with('title','All stores');
    }
    public function add()
    {
    	return view('admin.stores.add')
    			->with('title',' Add New Store ');
    }
    public function postAdd(Request $request)
    {
    	$validator =  Validator::make($request->all(),[
							'image'=>'image|mimes:jpg,png,jpeg',
							'name'=>'required|unique:stores'
							]);
		if ($validator->fails()) {
			if ($request->ajax()) {
				return [
					'state'=>0
				];
			}
			return  back()
					->withErrors($validator) 
					->withInput();  
		}else{
			$data =  new Store;
			$data->name      =  $request->name;
			$data->name_en   =  $request->name_en;
			$data->save();
			if ($request->ajax()) {
				return [
					'state'=>1,
					'id'=>$data->id,
					'name'=>$data->title
				];
			}
			return redirect('admin/stores')
					->with('yes',' Added Successfully');
		}
    	
    }
    public function edit($id)
    {
    	$data =  Store::find($id);
    	return view('admin.stores.edit')
    			->with('data',$data)
    			->with('title',$data->name);
    }
    public function postEdit(Request $request,$id)
    {
    	$request->validate([
    			'image'=>'image|mimes:jpg,png,jpeg',
    			
    			]);
    	$data =  Store::find($id);
    	$data->name      =  $request->name;
        $data->name_en   =  $request->name_en;
    	$data->save();
    	return redirect('admin/stores')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  Store::find($id);
    	if ($data) {
    		$data->delete();
    	}
    	return back()
    			->with('yes','Done Successfully');
    }
}
