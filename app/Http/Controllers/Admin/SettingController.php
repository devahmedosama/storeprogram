<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()  {
        $data =  Setting::first();
        return view('admin.setting')
                ->with('data',$data);
    }
    public function edit(Request $request)  {
        $request->validate([
            'img'=>'mimes:jpg,png,jpeg'
        ]);
        $data =  Setting::first();
        $data->name =  $request->name;
        $data->name_en =  $request->name_en;
        if ($request->hasFile('logo')) {
            $file  =  $request->file('logo');
            $filename =  'uploads/products/logo.jpg';
            $file->move('uploads/products',$filename);
            $data->logo =  $filename;
        }
        $data->save();
        return back()
                 ->with('yes',trans('home.Done Successfully'));
        ;
    }
}
