@extends('admin.content.layout')
@section('content')
<style>
    .home-ul li{
        display: inline-block;
        margin:5px
    }
</style>
    <div class="row">
    	<div class="col-md-12">
    		<ul class="home-ul">
                @if(auth()->user()->type == 0)
                    <li> 
                        <a href="{{ URL::to('admin/inventories') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Inventory') }}
                        </a>
                    </li>    
                    <li> 
                        <a href="{{ URL::to('admin/purchases/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Purchases') }}
                        </a>
                    </li>              
                    <li> 
                        <a href="{{ URL::to('admin/recives/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Recives') }}
                        </a>
                    </li> 
                    <li> 
                        <a href="{{ URL::to('admin/stock-movements/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Stock Movements') }}
                        </a>
                    </li> 
                    <li> 
                        <a href="{{ URL::to('admin/stocks') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Stock') }}
                        </a>
                    </li>  
                    <li> 
                        <a href="{{ URL::to('admin/products/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Product') }}
                        </a>
                    </li>  
                @endif
                @if(auth()->user()->type == 1)
                    <li> 
                        <a href="{{ URL::to('admin/ask-store') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Ask Bills') }}
                        </a>
                        <span class="number_span">
                            {{ $asks }}
                        </span>
                    </li>
                    <li> 
                        <a href="{{ URL::to('admin/purchases') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Purchases') }}
                        </a>
                    </li>  
                    <li> 
                        <a href="{{ URL::to('admin/recives/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Recives') }}
                        </a>
                    </li>
                    <li> 
                        <a href="{{ URL::to('admin/shop-movements/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Shop Movements') }}
                        </a>
                    </li>
                    <li> 
                        <a href="{{ URL::to('admin/stock-movements/move') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Stock Movements') }}
                        </a>
                    </li>
                    <li> 
                        <a href="{{ URL::to('admin/sales-bills/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Sales Bills') }}
                        </a>
                    </li>
                    <li> 
                        <a href="{{ URL::to('admin/sales-bills/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Sales Bills') }}
                        </a>
                    </li>
                    <li> 
                        <a href="{{ URL::to('admin/stock') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Stock') }}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->type == 3)
                    <li> 
                        <a href="{{ URL::to('admin/ask-bills/add') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Ask Bills') }}
                        </a>
                    </li>
                    <li> 
                        <a href="{{ URL::to('admin/my-bills') }}" class="btn btn-md btn-primary">
                            {{ trans('home.Recives') }}
                        </a>
                    </li>
                @endif
    		</ul>
    	</div>
    </div>

@stop