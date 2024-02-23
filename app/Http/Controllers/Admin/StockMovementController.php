<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Store;
use App\Models\Suplier;

class StockMovementController extends Controller
{
    public function move()  {

        $stores =  Store::items();
        $title  =  trans('home.Stock Movement');
        $items  =  Suplier::items();
        return view('admin.stocks.move')
                    ->with('stores',$stores)
                    ->with('title',$title)
                    ->with('items',$items)
                    ;
    }
    public function index()  {
        $allData = StockMovement::OrderBy('id','desc')->where(function($q){
                    if (auth()->user()->type == 1 ) {
                        $q->where('store_id',auth()->user()->store_id);
                        $q->orWhere('store_to',auth()->user()->store_id);
                    }
                  })->paginate(30);
        return  view('admin.stocks.stock_movements')
                    ->with('allData',$allData)
                    ->with('title',trans('home.Stock Movements'));
    }
    public function show($id)  {
        $data =  StockMovement::find($id);
        $data->amount = $data->items()->sum('amount');
        $data->recived_amount =  $data->items()->sum('recived_amount'); 
        return view('admin.stocks.view')
                    ->with('data',$data)
                    ;
    }
}
