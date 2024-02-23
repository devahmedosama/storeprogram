<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Suplier;
use Validator;
use App\Models\PurchaseItem;
use App\Models\Store;
use App\Models\Recive;
use Barryvdh\DomPDF\Facade\Pdf;


class PurchaseController extends Controller
{
    public function index()
    {
    	$allData =  Purchase::OrderBy('id','desc')->paginate(30);
    	return  view('admin.purchases.index')
    				->with('allData',$allData)
    				->with('title','All purchases');
    }
    public function add()
    {
        $items =  Suplier::items();
        $ways =  Purchase::ways();
    	return view('admin.purchases.add')
                ->with('items',$items)
				->with('ways',$ways)
    			->with('title',' Add New Purchase');
    }
    public function postAdd(Request $request)
    {
    	$validator =  Validator::make($request->all(),[
							'suplier_id'=>'required|exists:supliers,id',
							'product_id'=>'required'
							]);
		if ($validator->fails()) {
			return  back()
					->withErrors($validator) 
					->withInput();  
		}else{
			$data             =  new Purchase;
			$data->suplier_id =  $request->suplier_id;
			$data->no         =  mt_rand(11111,99999);
			$data->user_id    = auth()->id();
			$data->signature  = $request->image;
			$data->save();
			$data->no   =  sprintf('%04d',$data->id);
			$data->save();
			foreach ($request->product_id as $key => $id) {
				$item             =  new PurchaseItem;
				$item->product_id =  $id;
				$item->amount   =  $request->quantity[$key];
				$item->purchase_id = $data->id;
				$item->save();
			}
			return redirect('admin/purchases')
					->with('yes',' Added Successfully');
		}
    	
    }
    public function recive($id)
    {
    	$data  =  Purchase::find($id);
		$items =  Store::items();
    	return view('admin.purchases.recive')
    			->with('data',$data)
				->with('items',$items)
    			->with('title',trans('home.Purchase No').' '.$data->no)
				;
    }
    public function postEdit(Request $request,$id)
    {
    	$request->validate([
    			'image'=>'image|mimes:jpg,png,jpeg',
    			
    			]);
    	$data =  Purchase::find($id);
    	$data->name      =  $request->name;
        $data->name_en   =  $request->name_en;
    	$data->save();
    	return redirect('admin/purchases')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  Purchase::find($id);
    	if ($data && empty($data->recive)) {
    		$data->delete();
			return back()
    			->with('yes','Done Successfully');
    	}else{
			return back()
					->with('no',trans('home.There`s recive on this purchase so  you can`t delete'));
		}
    	
    }
	public function search(Request $request){
        $allData =  Purchase::where('no','LIKE','%'.$request->name.'%')
                          ->take(7)->get();
	    foreach ($allData as $data) {
			$data->supplier_name  =  $data->supplier->title;
			$data->store_id =  $data->recive?$data->recive->store_id:null;
		    $items  =  $data->items ;
			$recive =  Recive::where('purchase_id',$data->id)->first();
			if ($recive) {
				$items  =  $recive->items ;
			}
			$arr = [];
			foreach ($items as $key => $item) {
				array_push($arr,[
					'title'=>$item->product->title,
					'code'=>$item->product->code,
					'id'=>$item->product_id,
					'amount'=>$item->amount,
					'product_id'=>$item->product_id,
					'recived_amount'=>$item->recived_amount??0
				]);
			}
			$data->purchase_items =  $arr;
		}
        return  [
            'data'=>$allData,
            'count'=>$allData->count()
        ];
    }
	public function show($id)  {
		$data =  Purchase::find($id);
		return view('admin.purchases.send')
		          ->with('data',$data)
				  ->with('title',trans('home.View Purchase'));
		
	}
	public function send_email()  {
		return redirect('admin/purchases')
					->with('yes',trans('home.Done Successfully'));
	}
	public function view_pdf($id)  {
		$data =  Purchase::find($id);
		$setting  =  \App\Models\Setting::first();
		$data = [
			'data'=>$data,
			'setting'=>$setting
		];
		$pdf = Pdf::loadView('admin.pdfs.purchase',$data);
		return $pdf->stream();
	}
}
