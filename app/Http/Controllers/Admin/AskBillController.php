<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AskBillItem;
use App\Models\AskBill;
use App\Models\Store;
use App\Models\Suplier;
class AskBillController extends Controller
{
    public function add()  {
        $stores =  Store::items();
        $items  =  Suplier::items();
        $title  =  trans('home.Ask Bills');
        return view('admin.ask_bills.add')
                    ->with('stores',$stores)
                    ->with('title',$title)
                    ->with('items',$items)
                    ;
    }
    public function postAdd(Request $request)  {
		$request->validate([
			'store_id'=>'required',
            'product_id'=>'required',
            'image'=>'required'
		],[
            'product_id.required'=>trans('home.please choose products to move')
        ]);
        \DB::beginTransaction();
        $data                 =  new AskBill;
        $data->store_id       =  $request->store_id;
        $data->sales_man_id   =  auth()->user()->sales_man_id;
        $data->user_id        =  auth()->user()->id;
        $data->no             =  mt_rand(11111,99999);
        $data->user_id        = auth()->id();
        $data->signature      = $request->image;
        $data->save();
        $data->no         =  sprintf('%04d',$data->id);
        $data->save();
        foreach ($request->product_id as $key => $product_id) {
            $item              =  new AskBillItem;
            $item->product_id  = $product_id;
            $item->amount      = $request->quantity[$key];
            $item->ask_bill_id = $data->id;
            $item->save();
        }

        \DB::commit();
        return redirect('admin/ask-bills')
                   ->with('yes',trans('home.Done Successfully'));
	}
    public function index() {
        $allData =  AskBill::OrderBy('id','desc')->where(function($q){
                            if (auth()->user()->store_id) {
                                $q->where('store_id',auth()->user()->store_id);
                            }
                            if (auth()->user()->sales_man_id) {
                                $q->where('sales_man_id',auth()->user()->sales_man_id);
                            }
                        })->paginate(30);
        return view('admin.ask_bills.index')
                    ->with('allData',$allData)
                    ->with('title',trans('home.Ask Bills'));
    }
    public function ask_store()  {
        $allData =  AskBill::OrderBy('id','desc')->where(function($q){
                                if (auth()->user()->store_id) {
                                    $q->where('store_id',auth()->user()->store_id);
                                }
                                if (auth()->user()->sales_man_id) {
                                    $q->where('sales_man_id',auth()->user()->sales_man_id);
                                }
                            })->paginate(30);
        return view('admin.ask_bills.store')
            ->with('allData',$allData)
            ->with('title',trans('home.Ask Bills'));
    }
    public function show($id)  {
        $data =  AskBill::find($id);
        $data->amount = $data->items()->sum('amount');
        return view('admin.ask_bills.view')
                    ->with('data',$data)
                    ;
    }
    public function edit($id)  {
        $stores =  Store::items();
        $title  =  trans('home.Ask Bills');
        $items  =  Suplier::items();
        $data   =  AskBill::find($id);
        return view('admin.ask_bills.edit')
                    ->with('stores',$stores)
                    ->with('title',$title)
                    ->with('items',$items)
                    ->with('data',$data)
                    ;
    }
    public function postEdit($id,Request $request)  {
        \DB::beginTransaction();
        $data  =  AskBill::find($id);
        $data->store_id =  $request->store_id;
        $data->save();
        foreach ($request->product_id as $key=>$product_id ) {
             $item = AskBillItem::where('ask_bill_id',$data->id)
                                 ->where('product_id',$product_id)->first();
             $old_amount  =  0;
             if(empty($item)){
                $item =  new AskBillItem;
                $item->ask_bill_id  =  $data->id;
                $item->product_id = $product_id;
             }
             $item->amount          =  $request->quantity[$key];
             $item->save();
        }
        \DB::commit();
        return redirect('admin/ask-bills')
                 ->with('yes',trans('home.Done Successfully'));
    }
    public function update($id)  {
        $stores =  Store::items();
        $title  =  trans('home.Ask Bills');
        $items  =  Suplier::items();
        $data   =  AskBill::find($id);
        return view('admin.ask_bills.update')
                    ->with('stores',$stores)
                    ->with('title',$title)
                    ->with('items',$items)
                    ->with('data',$data)
                    ;
    }
    public function postUpdate($id,Request $request)  {
        \DB::beginTransaction();
        $data  =  AskBill::find($id);
        $data->store_signature =  $request->image;
        $data->state = 1;
        $data->save();
        foreach ($request->product_id as $key=>$product_id ) {
             $item = AskBillItem::where('ask_bill_id',$data->id)
                                 ->where('product_id',$product_id)->first();
             if(empty($item)){
                $item =  new AskBillItem;
                $item->ask_bill_id  =  $data->id;
                $item->product_id = $product_id;
             }
             $item->available_amount          =  $request->quantity[$key];
             $item->save();
        }
        \DB::commit();
        return redirect('admin/ask-store')
                 ->with('yes',trans('home.Done Successfully'));
    }
}
