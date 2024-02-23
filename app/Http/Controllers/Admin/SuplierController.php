<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suplier;
use Validator;

class SuplierController extends Controller
{
    public function index()
    {
    	$allData =  Suplier::OrderBy('id','desc')->paginate(30);
    	return  view('admin.supliers.index')
    				->with('allData',$allData)
    				->with('title',trans('home.Suppliers'));
    }
    public function add()
    {
    	return view('admin.supliers.add')
    			->with('title',trans('home.Add New'));
    }
    public function postAdd(Request $request)
    {
    	$validator =  Validator::make($request->all(),[
							'image'=>'image|mimes:jpg,png,jpeg',
							'name'=>'required|unique:supliers'
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
			$data =  new Suplier;
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
			return redirect('admin/supliers')
					->with('yes',' Added Successfully');
		}
    	
    }
    public function edit($id)
    {
    	$data =  Suplier::find($id);
    	return view('admin.supliers.edit')
    			->with('data',$data)
    			->with('title',$data->name);
    }
    public function postEdit(Request $request,$id)
    {
    	$request->validate([
    			'image'=>'image|mimes:jpg,png,jpeg',
    			
    			]);
    	$data =  Suplier::find($id);
    	$data->name      =  $request->name;
        $data->name_en   =  $request->name_en;
        $data->phone     =  $request->phone;
        $data->email     =  $request->email;
    	$data->save();
    	return redirect('admin/supliers')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  Suplier::find($id);
    	if ($data) {
    		$data->delete();
    	}
    	return back()
    			->with('yes','Done Successfully');
    }
}
