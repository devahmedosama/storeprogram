<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\InventoryProcess;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Suplier;
use App\Models\ProductMovement;

class InventoryController extends Controller
{
    public function index(Request $request)  {
        $data = InventoryProcess::where('user_id',auth()->id())->where('state',0)->first();
        if (empty($data)) {
            $data =  new InventoryProcess;
            $data->user_id = auth()->id();
            $data->save();
        }
        $allData    =  Stock::whereNotNull('store_id')->where(function($query) use($request){
                            if ($request->store_id) {
                                $query->where('store_id',$request->store_id);
                            }
                            if ($request->suplier_id) {
                                $query->whereHas('product',function($q){
                                    $q->where('suplier_id',app('request')->input('suplier_id'));
                                });
                            }
                        })->where(function($query) use($request){
                            if ($request->name) {
                                if ($request->name) {
                                    $query->whereHas('product',function($q){
                                        $q->where('name','LIKE','%'.app('request')->input('name').'%');
                                        $q->orWhere('name_en','LIKE','%'.app('request')->input('name').'%');
                                        $q->orWhere('code','LIKE','%'.app('request')->input('name').'%');
                                    });
                                }
                            }
                        })->paginate(50);
        $stores     =  Store::items(); 
        $supliers   =  Suplier::items(); 
        return view('admin.stocks.inventories')
                        ->with('allData',$allData)
                        ->with('title',trans('home.Inventories'))
                        ->with('stores',$stores)
                        ->with('data',$data)
                        ->with('supliers',$supliers)
                        ;
    }
    public function postAdd(Request  $request,$id)  {
        \DB::beginTransaction();
        $process =  InventoryProcess::where('user_id',auth()->id())->where('state',0)->first();
        if ($request->amount !=  $request->old_amount) {
            $data  =  new Inventory;
            $data->product_id  =  $id;
            $data->amount      =  $request->amount;
            $data->old_amount  =  $request->old_amount;
            $data->store_id    =  $request->store_id;
            $data->user_id     =  auth()->id();
            $data->inventory_process_id =  $process?$process->id:null;
            $data->save();
            $note     =  'عمليه  جرد تحديث الكمية من '.$request->old_amount.' إلي '.$request->amount.' في '.$data->store->name;
            $note_en  =  'Update inventory quantity form '.$request->old_amount.' to '.$request->amount.' in '.$data->store->name_en;
            $amount   =  $request->amount - $request->old_amount;
            $link     =  'inventories/view/'.$data->id;
            $type     =  'inventory_id';
            $store_id =  $request->store_id;
            if ($amount != 0) {
                ProductMovement::add_action($id,$store_id,$amount,$link,$note,$note_en,$data->id,$type);
            }
            Stock::update_stock($id,$store_id,$amount);
        }
        \DB::commit();
    }
    public function show($id)  {
        $data  =  Inventory::find($id);
        return view('admin.stocks.inventory_view')
                    ->with('data',$data);
    }
}
