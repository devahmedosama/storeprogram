<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SalesBill;
use App\Models\SalesBillItem;
use App\Models\SalesMan;
use App\Models\Store;
use App\Models\ProductMovement;
use App\Models\Stock;

class SalesBillController extends Controller
{
    public function add()  {
        $stores =  Store::items();
        $title  =  trans('home.Sales Bill');
        $items  =  SalesMan::items();
        return view('admin.bills.add')
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
        $data             =  new SalesBill;
        $data->store_id   =  $request->store_id;
        $data->sales_man_id   =  $request->sales_man_id;
        $data->no             =  mt_rand(11111,99999);
        $data->user_id       = auth()->id();
        $data->signature     = $request->image;
        $data->save();
        $data->no         =  sprintf('%04d',$data->id);
        $data->save();
        foreach ($request->product_id as $key => $product_id) {
            $item  =  new SalesBillItem;
            $item->product_id = $product_id;
            $item->amount   = $request->quantity[$key];
            $item->sales_bill_id = $data->id;
            $item->save();

            $note_en    =  'Sales Man Bill  No  '.$data->no ;
            $note       =  'فاتورة لمندوب مبيعات رقم '.$data->no;
            $store_id =  $data->store_id;
            $amount   =  $item->amount;
            $link    =  'sales-bills/view/'.$data->id;
            $type    =  'sales_bill_item_id';
            $amount2 =  $amount*-1 ;
            ProductMovement::add_action($product_id,$store_id,$amount2,$link,$note,$note_en,$item->id,$type);
            Stock::update_stock($product_id,$store_id,$amount2);
        }

        \DB::commit();
        return redirect('admin/sales-bills')
                   ->with('yes',trans('home.Done Successfully'));
	}
    public function index() {
        $allData =  SalesBill::OrderBy('id','desc')->where(function($q){
            if (auth()->user()->store_id) {
                $q->where('store_id',auth()->user()->store_id);
            }
            if (auth()->user()->shop_id) {
                $q->where('shop_id',auth()->user()->shop_id);
            }
        })->paginate(30);
        return view('admin.bills.index')
                    ->with('allData',$allData)
                    ->with('title',trans('home.Sales Bills'));
    }
    public function show($id)  {
        $data =  SalesBill::find($id);
        $data->amount = $data->items()->sum('amount');
        return view('admin.bills.view')
                    ->with('data',$data)
                    ;
    }
    public function edit($id)  {
        $stores =  Store::items();
        $title  =  trans('home.Sales Bill');
        $items  =  SalesMan::items();
        $data   =  SalesBill::find($id);
        foreach ($data->items as $key =>$item) {
              $stock     =  Stock::where('product_id',$item->product_id)
                              ->where('store_id',$data->store_id)->first();
              $item->max =  $item->amount + $stock->amount;
        }
        return view('admin.bills.edit')
                    ->with('stores',$stores)
                    ->with('title',$title)
                    ->with('items',$items)
                    ->with('data',$data)
                    ;
    }
    public function postEdit($id,Request $request)  {
        \DB::beginTransaction();
        $data  =  SalesBill::find($id);
        $data->sales_man_id =  $request->sales_man_id;
        $data->save();
        foreach ($request->product_id as $key=>$product_id ) {
             $item = SalesBillItem::where('sales_bill_id',$data->id)
                                 ->where('product_id',$product_id)->first();

             $old_amount  =  0;
             if(empty($item)){
                $item =  new SalesBillItem;
                $item->sales_bill_id  =  $data->id;
                $item->product_id = $product_id;
                $note    =  'تعديل فاتورة مبيعات  رقم '.$data->no;
                $note_en =   'update Sales bill no '.$data->no; 
                
             }else{
                $old_amount = $item->amount;
                $note = 'تعديل فاتوره مبيعات رقم '.$data->no.' من '.$old_amount.' إلي '.$request->quantity[$key];
                $note_en =  'update Sales bill no '.$data->no.' from '.$old_amount.' to '.$request->quantity[$key];
             }
             $item->amount          =  $request->quantity[$key];
             $item->save();
             $store_id =  $data->store_id;
             $amount  =   $old_amount -  $request->quantity[$key];
             $link    =  'sales-bills/view/'.$data->id;
             $type    =  'sales_bill_item_id';
             if ($amount != 0) {
                ProductMovement::add_action($product_id,$store_id,$amount,$link,$note,$note_en,$item->id,$type);
             }
             Stock::update_stock($product_id,$store_id,$amount);
        }
        \DB::commit();
        return redirect('admin/sales-bills')
                 ->with('yes',trans('home.Done Successfully'));
    }
}
