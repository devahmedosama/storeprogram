<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
class HomeController extends Controller
{
    public function login()
    {
       return view('admin.users.login');
    }
    public function logout($value='')
    {
        Auth::logout();
        return redirect('admin')
                ->with('yes','تم تسجيل الخروج  بنجاح');
    }
    public function postLogin(Request $request)
    {
    	if (Auth::attempt(['username'=>$request->username,'password'=>$request->password])) {
    		return redirect('admin')
    				->with('yes','loged ib successfully');
    	}else{
    		return  back()
    					->with('no','Error in username or password ');
    	}
    }
    public function index($value='')
    {
        $asks =  \App\Models\AskBill::where('state',0)
                        ->where(function($q){
                            if (auth()->user()->store_id) {
                                $q->where('store_id',auth()->user()->store_id);
                            }
                        })->count();
        return view('admin.index')
                ->with('asks',$asks);
    }
    public function contacts()
    {
        $allData =  \App\Models\Contact::OrderBy('id','desc')->paginate(30);
        return view('admin.contacts')
                    ->with('allData',$allData)
                       ;
    }
    public function delete_contacts($id)  {
        $data =  \App\Models\Contact::find($id);
        if ($data) {
            $data->delete();
        }
        return back()
                ->with('yes','Done Successfully');
    }
    public function profile ()
    {
        $data =  Auth::User();
        $langs = \App\Models\User::langs();
        return view('admin.users.profile')
                ->with('data',$data)
                ->with('langs',$langs)
                ;   
    }
    public function edit (Request $request)
    {
        $data        =  Auth::User();
        $data->username =  $request->username;
        $data->lang =  $request->lang;
        if ($request->password) {
            $data->password =  \Hash::make($request->password);
        }
        $data->save();
        return back()
                ->with('yes','تم  التعديل بنجاح');   
    }
}
