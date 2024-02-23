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
    		</ul>
    	</div>
    </div>

@stop