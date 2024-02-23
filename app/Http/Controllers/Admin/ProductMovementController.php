<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductMovement;
use App\Models\Product;

class ProductMovementController extends Controller
{
    public function index($id)  {

        $allData =  ProductMovement::whereNotNull('store_id')
                            ->where('product_id',$id)->paginate(100);
        $data    =  Product::find($id);
        return view('admin.movements.index')
                ->with('allData',$allData)
                ->with('data',$data)
                ->with('title',trans('home.Product Movement'));
    }
}
