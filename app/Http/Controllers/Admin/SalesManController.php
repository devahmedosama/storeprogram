<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesMan;
use Validator;

class SalesManController extends Controller
{
    public function index()
    {
    	$allData =  SalesMan::OrderBy('id','desc')->paginate(30);
    	return  view('admin.sales-mens.index')
    				->with('allData',$allData)
    				->with('title','All sales-mens');
    }
    public function add()
    {
    	return view('admin.sales-mens.add')
    			->with('title',' Add New SalesMan ');
    }
    public function postAdd(Request $request)
    {
    	$validator =  Validator::make($request->all(),[
							'image'=>'image|mimes:jpg,png,jpeg',
							'name'=>'required|unique:sales_men'
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
			$data =  new SalesMan;
			$data->name      =  $request->name;
			$data->name_en   =  $request->name_en;
			$data->phone     =  $request->phone;
			$data->email     =  $request->email;
			$data->save();
			if ($request->ajax()) {
				return [
					'state'=>1,
					'id'=>$data->id,
					'name'=>$data->title
				];
			}
			return redirect('admin/sales-men')
					->with('yes',' Added Successfully');
		}
    	
    }
    public function edit($id)
    {
    	$data =  SalesMan::find($id);
    	return view('admin.sales-mens.edit')
    			->with('data',$data)
    			->with('title',$data->name);
    }
    public function postEdit(Request $request,$id)
    {
    	$request->validate([
    			'image'=>'image|mimes:jpg,png,jpeg',
    			
    			]);
    	$data =  SalesMan::find($id);
    	$data->name      =  $request->name;
        $data->name_en   =  $request->name_en;
        $data->phone     =  $request->phone;
        $data->email     =  $request->email;
    	$data->save();
    	return redirect('admin/sales-men')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  SalesMan::find($id);
    	if ($data) {
    		$data->delete();
    	}
    	return back()
    			->with('yes','Done Successfully');
    }
}
