<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Suplier;
use Validator;
use App\Models\Stock;
use App\Models\Store;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
class ProductController extends Controller
{
    public function index()
    {
    	$allData =  Product::OrderBy('id','desc')->paginate(30);
        foreach ($allData as $key => $data) {
            $stock = Stock::whereNull('store_id')->where('product_id',$data->id)->first();
            $data->stock = $stock?$stock->amount:0 ;
        }
        $suppliers =  Suplier::items();
    	return  view('admin.products.index')
    				->with('allData',$allData)
                    ->with('items',$suppliers)
    				->with('title','All products');
    }
    public function search(Request $request){
        $data =  Product::where(function($query) use($request){
                                $query->where('name','LIKE','%'.$request->name.'%');
                                $query->orWhere('name_en','LIKE','%'.$request->name.'%');
                                $query->orWhere('code','LIKE','%'.$request->name.'%');
                             })
                          ->where(function($query){
                            if (app('request')->input('suplier_id')) {
                                $query->where('suplier_id',app('request')->input('suplier_id'));
                                $query->orWhereNull('suplier_id');
                            }
                          })
                          ->take(7)->get();
        return  [
            'data'=>$data,
            'count'=>$data->count()
        ];
    }
    public function add()
    {
        $suppliers =  Suplier::items();
    	return view('admin.products.add')
                ->with('items',$suppliers)
    			->with('title',' Add New Product ');
    }
    public function postAdd(Request $request)
    {
    	$validator =  Validator::make($request->all(),[
            'code'=>'required|unique:products',
            ]);
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return [
                        'state'=>0
                    ];
                }
                return  back()
                    ->withErrors($validator) 
                    ->withInput();  
            }else{
                    $data =  new Product;
                    $data->name       =  $request->name;
                    $data->code       =  $request->code;
                    $data->name_en    =  $request->name_en;
                    $data->suplier_id =  $request->suplier_id;
                    $data->save();
                    $data  =  Product::find($data->id);
                    if ($request->ajax()) {
                        return [
                            'state'=>1,
                            'id'=>$data->id,
                            'name'=>$data->title
                        ];
                    }
                    return redirect('admin/products')
    			             ->with('yes',' Added Successfully  ');
            }
    	    
    }
    public function edit($id)
    {
    	$data =  Product::find($id);
        $suppliers =  Suplier::items();
    	return view('admin.products.edit')
    			->with('data',$data)
                ->with('items',$suppliers)
    			->with('title',$data->name);
    }
    public function postEdit(Request $request,$id)
    {
        $request->validate([
            'name'=>'required|unique:products,name,'. $id ,
            ]);
    	$data =  Product::find($id);
    	$data->name       =  $request->name;
        $data->name_en    =  $request->name_en;
        $data->suplier_id =  $request->suplier_id;
        $data->code       =  $request->code;
    	$data->save();
    	return redirect('admin/products')
    			->with('yes',' Done Successfully');
    }
    public function delete($id)
    {
    	$data =  Product::find($id);
    	if ($data) {
    		$data->delete();
    	}
    	return back()
    			->with('yes','Done Successfully');
    }
    public function post_import(Request $request)  {
        $file = $request->file('file');
        // Read the Excel file and convert it to an array
        $rows = Excel::toArray([], $file)[0];
        $suplier_id = $request->suplier_id;
        $arr = [];
        $stores =  Store::get();
        foreach ($rows as $key => $row) {

             if ($key > 0) {
                $code    =    $row[0];
                $name    =    $row[2];
                $name_en =    $row[1];
                $amount  =    $row[3];
                if ($code ) {
                    $data  = Product::where('code',$code)->first();
                    if (empty($data) && $name ) {
                        $data  =  new Product;
                        $data->suplier_id =  $suplier_id;
                        $data->code  =  $code;
                        $data->name  =  $name ;
                        $data->name_en  =  $name_en ;
                        $data->save();
                        foreach ($stores as $key => $store) {
                            Stock::update_stock($data->id,$store->id,0);
                        }
                    }
                    if ($data) {
                        array_push($arr,[
                            'name'=>$data->title,
                            'amount'=>$amount,
                            'code'=>$code,
                            'id'=>$data->id,
                            'recived_amount'=>0
                        ]);
                    }
                    
                }
                
             }
        }
        if ($request->ajax()) {
            return $arr;
        }else{
            return back()
                    ->with('yes',trans('home.Done Successfully'));
        }
        
    }
}
