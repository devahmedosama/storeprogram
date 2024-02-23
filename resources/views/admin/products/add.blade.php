@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item">
					<i class="anticon anticon-home
				 m-r-5"></i>{{ trans('home.Home') }}</a>
                <a class="breadcrumb-item" href="{{ URL::to('admin/products') }}">
				{{ trans('home.Products') }}</a>
                <span class="breadcrumb-item active">{{ trans('home.Add New') }}</span>
            </nav>
        </div>
    </div>
	<div class="card">
		<div class="card-body">
			{{ Form::open(['url'=>'admin/products/add','files'=>true,'enctype'=>'multipart']) }}
			    
			    <div class="form-row">
				    <div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Code') }}</label>
			            {{ Form::text('code',null,['class'=>'form-control','required']) }}
			        </div>
			    	<div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Name') }}</label>
			            {{ Form::text('name',null,['class'=>'form-control','required']) }}
			        </div>
					<div class="form-group col-md-12">
			            <label for="inputEmail4">{{ trans('home.Name in english') }}</label>
			            {{ Form::text('name_en',null,['class'=>'form-control']) }}
			        </div>
					
			        <div class="form-group col-md-12 plus_div">
			            <label for="inputEmail4">{{ trans('home.Supplier') }}</label>
			            {{ Form::select('suplier_id',$items,null,['class'=>'form-control'
							,'placeholder'=>trans('home.Choose Supplier'),'id'=>'suplier_id']) }}
							<a data-toggle="modal" data-target="#supplier_form" class="plus_btn btn bt-xs btn-primary">+</a>	
			        </div>
			    </div>
			    <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
	@include('admin.popups.supplier')
	
@stop