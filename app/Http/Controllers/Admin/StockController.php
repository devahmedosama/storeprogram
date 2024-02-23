<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\StockMovementItem;
use App\Models\ProductMovement;

class StockController extends Controller
{
    public  function search()  {
        $allData  =  Stock::OrderBy('amount','desc')->where(function($q){
                                if (auth()->user()->type == 1) {
                                    $q->where('store_id',auth()->user()->store_id);
                                }else{
                                    $q->where('store_id',app('request')->input('store_id'));
                                }
                            })
                          ->where('amount','>',0)
                          ->whereHas('product',function($query){
                             $query->where('name','LIKE','%'.app('request')->input('name').'%');   
                             $query->orWhere('name_en','LIKE','%'.app('request')->input('name').'%');   
                            })->take(7)->get();
        $arr = [];
        foreach ($allData as $key => $item) {
            array_push($arr,[
                'title'=>$item->product->title,
                'id'=>$item->product_id,
                'amount'=>$item->amount,
                'product_id'=>$item->product_id,
            ]);
        }
        return  [
            'data'=>$arr,
            'count'=>$allData->count()
        ];
    }
    public function postMove(Request $request)  {
		$request->validate([
			'store_id'=>'required',
            'product_id'=>'required',
			'store_to' => [
				'required',
				function ($attribute, $value, $fail) use ($request) {
					if ($value == $request->input('store_id')) {
						$fail(trans('home.you should choose two different stores'));
					}
				},
			],
		],[
            'product_id.required'=>trans('home.please choose products to move')
        ]);
        \DB::beginTransaction();
        $data             =  new StockMovement;
        $data->store_id   =  $request->store_id;
        $data->store_to   =  $request->store_to;
        $data->no         =  mt_rand(11111,99999);
        $data->user_id    = auth()->id();
        $data->signature  = $request->image;
        $data->save();
        $data->no         =  sprintf('%04d',$data->id);
        $data->save();
        foreach ($request->product_id as $key => $product_id) {
            $item  =  new StockMovementItem;
            $item->product_id = $product_id;
            $item->amount   = $request->quantity[$key];
            $item->recived_amount =  auth()->user()->type==0?$item->amount:0;
            $item->stock_movement_id = $data->id;
            $item->save();

            $note_en  = 'Stock  Movement from store '.$data->store->name_en.' to store '.$data->storeto->name_en;
            $note =  'نقل منتجات  من  المخزن '.$data->store->name.' إلي مخزن '.$data->storeto->name;
            $store_from =  $data->store_id;
            $store_to =  $data->store_to;
            $amount   =  $item->amount;
            $link    =  'stock-movements/view/'.$data->id;
            $type    =  'stock_movement_item_id';
            $amount2 =  $amount*-1 ;
            ProductMovement::add_action($product_id,$store_from,$amount2,$link,$note,$note_en,$item->id,$type);
            ProductMovement::add_action($product_id,$store_to,$amount,$link,$note,$note_en,$item->id,$type);
            Stock::update_movement($product_id,$store_from,$store_to,$amount);
        }

        \DB::commit();
        return redirect('admin/stock-movements')
                   ->with('yes',trans('home.Stock Movements'));
	}
    public function index()  {
        $allData =  Stock::whereNull('store_id')->whereHas('product',function($query){
            $query->where('name','LIKE','%'.app('request')->input('name').'%');   
            $query->orWhere('name_en','LIKE','%'.app('request')->input('name').'%');   
            $query->orWhere('code','LIKE','%'.app('request')->input('name').'%');   
           })->paginate(30);
        return view('admin.stocks.index')
                    ->with('allData',$allData)
                    ->with('title',trans('home.Stock'));

    }
    public function view($id)  {
        $allData =  Stock::whereNotNull('store_id')->where('product_id',$id)->paginate(30);
        $data    =  \App\Models\Product::find($id); 
        return view('admin.stocks.product_stock')
                    ->with('allData',$allData)
                    ->with('data',$data)
                    ->with('title',trans('home.Stock'));
    }
    
}
