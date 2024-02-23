<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Store;
use App\Models\Shop;
use App\Models\ShopMovement;
use App\Models\ShopMovementItem;
use App\Models\ProductMovement;
use App\Models\Stock;

class ShopMovementController extends Controller
{
    public function move()  {

        $stores =  Store::items();
        $items  =  Shop::items();
        $title  =  trans('home.Shop Movement');
        return view('admin.shop_movements.move')
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
        $data             =  new ShopMovement;
        $data->store_id   =  $request->store_id;
        $data->shop_id   =  $request->shop_id;
        $data->user_id       = auth()->id();
        $data->signature     = $request->image;
        $data->save();
        $data->no         =  sprintf('%04d',$data->id);
        $data->save();
        foreach ($request->product_id as $key => $product_id) {
            $item                   =  new ShopMovementItem;
            $item->product_id       = $product_id;
            $item->amount           = $request->quantity[$key];
            $item->shop_movement_id = $data->id;
            $item->save();

            $note_en    =  'Shop Movement  No  '.$data->no ;
            $note       =  'نقل  الي محل '.$data->no;
            $store_id   =  $data->store_id;
            $amount     =  $item->amount;
            $link       =  'shop-movements/view/'.$data->id;
            $type       =  'shop_movement_item_id';
            $amount2    =  $amount*-1 ;
            ProductMovement::add_action($product_id,$store_id,$amount2,$link,$note,$note_en,$item->id,$type);
            Stock::update_stock($product_id,$store_id,$amount2);
        }

        \DB::commit();
        return redirect('admin/shop-movements')
                   ->with('yes',trans('home.Done Successfully'));
	}
    public function index()  {
        $allData = ShopMovement::OrderBy('id','desc')->where(function($q){
            if (auth()->user()->type == 1 ) {
                $q->where('store_id',auth()->user()->store_id);
            }
          })->paginate(30);
        return view('admin.shop_movements.index')
                    ->with('allData',$allData)
                    ->with('title',trans('home.Shop Movements'));
    }
    public function show($id)  {
        $data =  ShopMovement::find($id);
        $data->amount = $data->items()->sum('amount');
        $data->recived_amount =  $data->items()->sum('recived_amount'); 
        return view('admin.shop_movements.view')
                    ->with('data',$data)
                    ;
    }
    public function edit($id)  {
        $stores =  Store::items();
        $title  =  trans('home.Shop Movement');
        $items  =  Shop::items();
        $data   =  ShopMovement::find($id);
        return view('admin.shop_movements.edit')
                    ->with('stores',$stores)
                    ->with('title',$title)
                    ->with('items',$items)
                    ->with('data',$data)
                    ;
    }
    public function postEdit($id,Request $request)  {
        \DB::beginTransaction();
        $data  =  ShopMovement::find($id);
        foreach ($request->product_id as $key=>$product_id ) {
             $item = ShopMovementItem::where('shop_movement_id',$data->id)
                                 ->where('product_id',$product_id)->first();

             $old_amount  =  0;
             if(empty($item)){
                $item =  new ShopMovementItem;
                $item->shop_movement_id  =  $data->id;
                $item->product_id = $product_id;
                $note    =  'تعديل فاتورة نقل الي محزن  رقم '.$data->no;
                $note_en =   'update shop movement no '.$data->no; 
                
             }else{
                $old_amount = $item->amount;
                $note = 'تعديل فاتوره الي مخزن رقم '.$data->no.' من '.$old_amount.' إلي '.$request->quantity[$key];
                $note_en =  'update shop movement no '.$data->no.' from '.$old_amount.' to '.$request->quantity[$key];
             }
             $item->amount          =  $request->quantity[$key];
             $item->save();
             $store_id =  $data->store_id;
             $amount  =   $old_amount -  $request->quantity[$key];
             $link    =  'shop-movements/view/'.$data->id;
             $type    =  'shop_movement_item_id';
             if ($amount != 0) {
                ProductMovement::add_action($product_id,$store_id,$amount,$link,$note,$note_en,$item->id,$type);
             }
             Stock::update_stock($product_id,$store_id,$amount);
        }
        \DB::commit();
        return redirect('admin/shop-movements')
                 ->with('yes',trans('home.Done Successfully'));
    }
}
