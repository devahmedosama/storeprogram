<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\Admin as Admin;

Route::get('login',[Admin\HomeController::class,'login'])->name('login');
Route::post('login',[Admin\HomeController::class,'postLogin']);
Route::get('logout',[Admin\HomeController::class,'logout']);
Route::get('/',[Admin\HomeController::class,'login']);
Route::group(['prefix'=>'admin','middleware'=>['auth','set_lang']],function(){


   Route::get('/',[Admin\HomeController::class,'index']);
   Route::get('profile',[Admin\HomeController::class,'profile']);
   Route::post('profile',[Admin\HomeController::class,'edit']);
   Route::get('settings',[Admin\SettingController::class,'index']);
   Route::post('settings',[Admin\SettingController::class,'edit']);

    //supliers
   Route::get('supliers',[Admin\SuplierController::class,'index']);
   Route::get('supliers/add',[Admin\SuplierController::class,'add']);
   Route::post('supliers/add',[Admin\SuplierController::class,'postAdd']);
   Route::get('supliers/delete/{id}',[Admin\SuplierController::class,'delete']);
   Route::get('supliers/edit/{id}',[Admin\SuplierController::class,'edit']);
   Route::post('supliers/edit/{id}',[Admin\SuplierController::class,'postEdit']);
   
   //users
   Route::get('users',[Admin\UserController::class,'index']);
   Route::get('users/add',[Admin\UserController::class,'add']);
   Route::post('users/add',[Admin\UserController::class,'postAdd']);
   Route::get('users/activate/{id}',[Admin\UserController::class,'activate']);
   Route::get('users/edit/{id}',[Admin\UserController::class,'edit']);
   Route::post('users/edit/{id}',[Admin\UserController::class,'postEdit']);

   // sales ments
   Route::get('sales-men',[Admin\SalesManController::class,'index']);
   Route::get('sales-men/add',[Admin\SalesManController::class,'add']);
   Route::post('sales-men/add',[Admin\SalesManController::class,'postAdd']);
   Route::get('sales-men/delete/{id}',[Admin\SalesManController::class,'delete']);
   Route::get('sales-men/edit/{id}',[Admin\SalesManController::class,'edit']);
   Route::post('sales-men/edit/{id}',[Admin\SalesManController::class,'postEdit']);

    //products
    Route::get('products',[Admin\ProductController::class,'index']);
    Route::get('products/add',[Admin\ProductController::class,'add']);
    Route::get('products/search',[Admin\ProductController::class,'search']);
    Route::post('products/add',[Admin\ProductController::class,'postAdd']);
    Route::post('products/import',[Admin\ProductController::class,'post_import']);
    Route::get('products/delete/{id}',[Admin\ProductController::class,'delete']);
    Route::get('products/edit/{id}',[Admin\ProductController::class,'edit']);
    Route::post('products/edit/{id}',[Admin\ProductController::class,'postEdit']);

    //product movement
    Route::get('product-movement/{id}',[Admin\ProductMovementController::class,'index']);

    //stores
    Route::get('stores',[Admin\StoreController::class,'index']);
    Route::get('stores/add',[Admin\StoreController::class,'add']);
    Route::post('stores/add',[Admin\StoreController::class,'postAdd']);
    Route::get('stores/delete/{id}',[Admin\StoreController::class,'delete']);
    Route::get('stores/edit/{id}',[Admin\StoreController::class,'edit']);
    Route::post('stores/edit/{id}',[Admin\StoreController::class,'postEdit']);

    //shops
    Route::get('shops',[Admin\ShopController::class,'index']);
    Route::get('shops/add',[Admin\ShopController::class,'add']);
    Route::post('shops/add',[Admin\ShopController::class,'postAdd']);
    Route::get('shops/delete/{id}',[Admin\ShopController::class,'delete']);
    Route::get('shops/edit/{id}',[Admin\ShopController::class,'edit']);
    Route::post('shops/edit/{id}',[Admin\ShopController::class,'postEdit']);

    //purchases
    Route::get('purchases',[Admin\PurchaseController::class,'index']);
    Route::get('view-pdf/{id}',[Admin\PurchaseController::class,'view_pdf']);
    Route::get('purchases/view/{id}',[Admin\PurchaseController::class,'show']);
    Route::get('purchases/search',[Admin\PurchaseController::class,'search']);
    Route::get('purchases/add',[Admin\PurchaseController::class,'add']);
    Route::get('purchases/delete/{id}',[Admin\PurchaseController::class,'delete']);
    Route::post('purchases/add',[Admin\PurchaseController::class,'postAdd']);
    Route::post('send/email/{id}',[Admin\PurchaseController::class,'send_email']);
    

    //recive purchase
    Route::get('recives',[Admin\ReciveController::class,'index']);
    Route::get('recives/view/{id}',[Admin\ReciveController::class,'show']);
    Route::get('recives/add',[Admin\ReciveController::class,'add']);
    Route::post('recives/add',[Admin\ReciveController::class,'postAdd']);
    Route::get('recives/edit/{id}',[Admin\ReciveController::class,'edit']);
    Route::post('recives/edit/{id}',[Admin\ReciveController::class,'postEdit']);
    Route::get('purchases/recive/{id}',[Admin\ReciveController::class,'recive']);
    Route::post('purchases/recive/{id}',[Admin\ReciveController::class,'postRecive']);

    //stock-movements 
    Route::get('stock-movements/move',[Admin\StockMovementController::class,'move']);
    Route::get('stock-movements',[Admin\StockMovementController::class,'index']);
    Route::get('stock/search',[Admin\StockController::class,'search']);
    Route::get('stocks',[Admin\StockController::class,'index']);
    Route::get('stocks/view/{id}',[Admin\StockController::class,'view']);
    Route::post('stock/move',[Admin\StockController::class,'postMove']);
    Route::get('stock-movements/view/{id}',[Admin\StockMovementController::class,'show']);

    //shop-movements 
    Route::get('shop-movements/add',[Admin\ShopMovementController::class,'move']);
    Route::post('shop-movements/add',[Admin\ShopMovementController::class,'postAdd']);
    Route::get('shop-movements',[Admin\ShopMovementController::class,'index']);
    Route::get('shop-movements/view/{id}',[Admin\ShopMovementController::class,'show']);
    Route::get('shop-movements/edit/{id}',[Admin\ShopMovementController::class,'edit']);
    Route::post('shop-movements/edit/{id}',[Admin\ShopMovementController::class,'postEdit']);
    
    //recive purchase
    Route::get('sales-bills',[Admin\SalesBillController::class,'index']);
    Route::get('sales-bills/view/{id}',[Admin\SalesBillController::class,'show']);
    Route::get('sales-bills/add',[Admin\SalesBillController::class,'add']);
    Route::post('sales-bills/add',[Admin\SalesBillController::class,'postAdd']);
    Route::get('sales-bills/edit/{id}',[Admin\SalesBillController::class,'edit']);
    Route::post('sales-bills/edit/{id}',[Admin\SalesBillController::class,'postEdit']);
    
    //inventories
    Route::get('inventories',[Admin\InventoryController::class,'index']);
    Route::get('inventories/add/{id}',[Admin\InventoryController::class,'add']);
    Route::get('inventories/view/{id}',[Admin\InventoryController::class,'show']);
    Route::post('inventories/add/{id}',[Admin\InventoryController::class,'postAdd']);

    //proccess 
    Route::get('processes',[Admin\InventoryProcessController::class,'index']);
    Route::get('view-process/{id}',[Admin\InventoryProcessController::class,'show']);
    Route::post('finish-process',[Admin\InventoryProcessController::class,'postAdd']);
    

});
