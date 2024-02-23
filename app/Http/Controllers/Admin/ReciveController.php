<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recive;
use App\Models\ReciveItem;
use App\Models\Purchase;
use App\Models\Store;
use DB;
use App\Models\ProductMovement;
use App\Models\Stock;
use App\Models\Suplier;

class ReciveController extends Controller
{
    public function recive($id)  {
        $data    =  Purchase::find($id);
        $title   =  trans('home.Purchase No').' '.$data->no;
        $items   =  $data->items;
        $recive  =  Recive::where('purchase_id',$id)->first();
        if ($recive) {
            $items =  $recive->items;
        }
        $stores  =  Store::items();
        return view('admin.recives.purchase')
                    ->with('data',$data)
                    ->with('items',$items)
                    ->with('stores',$stores)
                    ->with('title',$title)
                    ;
    }
    public function postRecive($id,Request $request)  {
        $request->validate([
			'store_id'=>'required',
            'product_id'=>'required',
			
		],[
            'product_id.required'=>trans('home.please choose products to move')
        ]);
        $arr  =  Recive::recive_arr();
        DB::beginTransaction();
        $data  =  Recive::where('purchase_id',$id)->first();
        if (empty($data)) {
            $data =  new Recive;
            $data->purchase_id =  $id;
            $data->store_id    =  $request->store_id;
            $data->user_id   =  auth()->id();
            $data->signature =  $request->image;
            $data->save();
            $data->no  =  sprintf('%04d',$data->id);
            $data->save();
        }
        foreach ($arr as $product_id => $obj) {
            $item = ReciveItem::where('recive_id',$data->id)
                                ->where('product_id',$product_id)->first();

            $old_amount  =  0;
            if(empty($item)){
               $item =  new ReciveItem;
               $item->recive_id  =  $data->id;
               $item->product_id = $product_id;
               if($data->purchase){
                   $note    =  'استلام فاتورة رقم '.$data->no;
                   $note_en =  'Recived Bill No '.$data->no;
               }else {
                   $note    =  'تعديل فاتورة  استلام رقم '.$data->no;
                   $note_en =   'update recive bill no '.$data->no; 
               }
               
            }else{
               $old_amount = $item->recived_amount;
               $note = 'تعديل فاتوره  رقم '.$data->no.' من '.$old_amount.' إلي '.$obj['recived_amount'];
               $note_en =  'update  bill no '.$data->no.' from '.$old_amount.' to '.$obj['recived_amount'];
            }
            $item->amount          =  $obj['amount'];
            $item->recived_amount  =  $obj['recived_amount'];
            $item->save();
            $store_id =  $data->store_id;
            $amount  =  $obj['recived_amount'] - $old_amount;
            $link    =  'recives/view/'.$data->id;
            $type    =  'recive_item_id';
            if ($amount != 0) {
               ProductMovement::add_action($product_id,$store_id,$amount,$link,$note,$note_en,$item->id,$type);
            }
            Stock::update_stock($product_id,$store_id,$amount);
        }
        DB::commit();
        return redirect('admin/recives')
                    ->with('yes',trans('home.Done Successfully'));
    }
    public function index()  {
        $allData  =  Recive::OrderBy('id','desc')->where(function($q){
                            if (auth()->user()->type == 1) {
                                $q->where('store_id',auth()->user()->store_id);
                            }
                        })->paginate(30);
        foreach ($allData as $key => $data) {
            $data->amount = $data->items()->sum('amount');
            $data->recived_amount =  $data->items()->sum('recived_amount');
        }
        return view('admin.recives.index')
                    ->with('allData',$allData)
                    ->with('title',trans('home.Recive'));
    }
    public function show($id)  {
        $data =  Recive::find($id);
        $data->amount = $data->items()->sum('amount');
        $data->recived_amount =  $data->items()->sum('recived_amount');
        return view('admin.recives.view')
                    ->with('data',$data)
                    ;
    }
    public function add()  {
        $title   =  trans('home.Recive');
        $stores  =  Store::items();
        $supliers  =  Suplier::items();
        return view('admin.recives.add')
                    ->with('stores',$stores)
                    ->with('supliers',$supliers)
                    ->with('items',$supliers)
                    ->with('title',$title)
                    ;
    }
    public function postAdd(Request $request) {
        $request->validate([
			'store_id'=>'required',
            'product_id'=>'required',
			
		],[
            'product_id.required'=>trans('home.please choose products to move')
        ]);
        $arr  = Recive::recive_arr();
        DB::beginTransaction();
        if ($request->purchase_id) {
            $data  =  Recive::where('purchase_id',$request->purchase_id)->first();
            if (empty($data)) {
                $data =  new Recive;
                $data->purchase_id =  $request->purchase_id;
                $data->store_id    =  $request->store_id;
            }
        }else{
            $data =  new Recive;
            $data->store_id    =  $request->store_id;
            $data->suplier_id  =  $request->suplier_id;
        }
        $data->user_id   =  auth()->id();
        $data->signature =  $request->image;
        $data->save();
        $data->no        =  sprintf('%04d',$data->id);
        $data->save();
        foreach ($arr as $product_id => $obj) {
            $item = ReciveItem::where('recive_id',$data->id)
                                ->where('product_id',$product_id)->first();

            $old_amount  =  0;
            if(empty($item)){
               $item =  new ReciveItem;
               $item->recive_id  =  $data->id;
               $item->product_id = $product_id;
                $note    =  'استلام فاتورة رقم '.$data->no;
                $note_en =  'Recived Bill No '.$data->no;
               
               
            }else{
               $old_amount = $item->recived_amount;
               $note = 'تعديل فاتوره  رقم '.$data->no.' من '.$old_amount.' إلي '.$obj['recived_amount'];
               $note_en =  'update  bill no '.$data->no.' from '.$old_amount.' to '.$obj['recived_amount'];
            }
            $item->amount          =  $obj['amount'];
            $item->recived_amount  =  $obj['recived_amount'];
            $item->save();
            $store_id =  $data->store_id;
            $amount  =  $obj['recived_amount'] - $old_amount;
            $link    =  'recives/view/'.$data->id;
            $type    =  'recive_item_id';
            if ($amount != 0) {
               ProductMovement::add_action($product_id,$store_id,$amount,$link,$note,$note_en,$item->id,$type);
            }
            Stock::update_stock($product_id,$store_id,$amount);
        }
        DB::commit();
        return redirect('admin/recives')
                    ->with('yes',trans('home.Done Successfully'));
    }
    public function edit($id)  {
        $title   =  trans('home.Recive');
        $data    =   Recive::find($id);
        return view('admin.recives.edit')
                    ->with('data',$data)
                    ->with('title',$title)
                    ;
    }
    public function postEdit($id,Request $request)  {
        $arr  = Recive::recive_arr();
        DB::beginTransaction();
        $data  =  Recive::find($id);
        foreach ($arr as $product_id => $obj) {
             $item = ReciveItem::where('recive_id',$data->id)
                                 ->where('product_id',$product_id)->first();

             $old_amount  =  0;
             if(empty($item)){
                $item =  new ReciveItem;
                $item->recive_id  =  $data->id;
                $item->product_id = $product_id;
                if($data->purchase){
                    $note    =  'استلام فاتورة رقم '.$data->no;
                    $note_en =  'Recived Bill No '.$data->no;
                }else {
                    $note    =  'تعديل فاتورة  استلام رقم '.$data->no;
                    $note_en =   'update recive bill no '.$data->no; 
                }
                
             }else{
                $old_amount = $item->recived_amount;
                $note = 'تعديل فاتوره  رقم '.$data->no.' من '.$old_amount.' إلي '.$obj['recived_amount'];
                $note_en =  'update  bill no '.$data->no.' from '.$old_amount.' to '.$obj['recived_amount'];
             }
             $item->amount          =  $obj['amount'];
             $item->recived_amount  =  $obj['recived_amount'];
             $item->save();
             $store_id =  $data->store_id;
             $amount  =  $obj['recived_amount'] - $old_amount;
             $link    =  'recives/view/'.$data->id;
             $type    =  'recive_item_id';
             if ($amount != 0) {
                ProductMovement::add_action($product_id,$store_id,$amount,$link,$note,$note_en,$item->id,$type);
             }
             Stock::update_stock($product_id,$store_id,$amount);
        }
        DB::commit();
        return redirect('admin/recives')
                 ->with('yes',trans('home.Done Successfully'));
    }
}
