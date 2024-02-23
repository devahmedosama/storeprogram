<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryProcess;
use App\Exports\ProcessExport;
use Validator;

class InventoryProcessController extends Controller
{
    public function index()  {
        $allData =  InventoryProcess::OrderBy('id','desc')
                    ->where('state',1)->paginate(30);
        return view('admin.processes.index')
                    ->with('allData',$allData)
                    ->with('title',trans('home.Inventory Process'));
    }
    public function show($id)  {
        return \Excel::download(new ProcessExport($id), 'inventory_no'.$id.'.xlsx');
    }
    public function postAdd(Request $request) {
        $validator =  Validator::make($request->all(),[
            'image'=>'required',
           ]);
        if ($validator->fails()) {
            return  back()
                ->with('no',trans('home.Please Fill Your Signature'));  
        }else{
            $data = InventoryProcess::where('user_id',auth()->id())->where('state',0)->first();
            $data->state = 1;
            $data->signature  = $request->image;
            $data->save();
            return redirect('admin/processes')
                        ->with('yes',trans('home.Done Successfully'));
        }
        
    }
}
