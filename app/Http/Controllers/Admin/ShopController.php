<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Validator;

class ShopController extends Controller
{
    public function index()
    {
    	$allData =  Shop::OrderBy('id','desc')->paginate(30);
    	return  view('admin.shops.index')
    				->with('allData',$allData)
    				->with('title','All shops');
    }
    public function add()
    {
    	return view('admin.shops.add')
    			->with('title',' Add New Shop ');
    }
    public function postAdd(Request $request)
    {
    	$validator =  Validator::make($request->all(),[
							'image'=>'image|mimes:jpg,png,jpeg',
							'name'=>'required|unique:shops'
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
			$data =  new Shop;
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
			return redirect('admin/shops')
					->with('yes',' Added Successfully');
		}
    	
    }
    public function edit($id)
    {
    	$data =  Shop::find($id);
    	return view('admin.shops.edit')
    			->with('data',$data)
    			->with('title',$data->name);
    }
    public function postEdit(Request $request,$id)
    {
    	$request->validate([
    			'image'=>'image|mimes:jpg,png,jpeg',
    			
    			]);
    	$data =  Shop::find($id);
    	$data->name      =  $request->name;
        $data->name_en   =  $request->name_en;
    	$data->save();
    	return redirect('admin/shops')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  Shop::find($id);
    	if ($data) {
    		$data->delete();
    	}
    	return back()
    			->with('yes','Done Successfully');
    }
}
