@extends('admin.content.layout')
@section('content')
	<div class="page-header">
        <div class="header-sub-title">
            <nav class="breadcrumb breadcrumb-dash">
                <a href="{{ URL::to('admin') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>{{ trans('home.Home') }}</a>
                <span class="breadcrumb-item active">{{ $data->username }}</span>
            </nav>
        </div>
    </div>
	<div class="card"> 
		<div class="card-body">
			{{ Form::open(['url'=>'admin/users/edit/'.$data->id,'files'=>true,'enctype'=>'multipart']) }}
			    <div class="form-row">
			        <div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Name') }}</label>
			            {{ Form::text('username',$data->username,['class'=>'form-control','placeholder'=>trans('home.Name'),'required']) }}
			        </div>
					<div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Type') }}</label>
			            {{ Form::select('type',$types,$data->type,['class'=>'form-control','required']) }}
			        </div>
					<div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Store') }}</label>
			            {{ Form::select('store_id',$stores,$data->store_id,['class'=>'form-control','placeholder'=>trans('home.Choose Store')]) }}
			        </div>
					<div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Shop') }}</label>
			            {{ Form::select('shop_id',$shops,$data->shop_id,['class'=>'form-control','placeholder'=>trans('home.Choose Shop')]) }}
			        </div>
			    </div>
			    
			    <div class="form-row">
			        <div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Password') }}</label>
			            {{ Form::password('password',['class'=>'form-control']) }}
			        </div>
			        <div class="form-group col-md-6">
			            <label for="inputEmail4">{{ trans('home.Confirm Password') }}</label>
			            {{ Form::password('confirm_password',['class'=>'form-control']) }}
			        </div>
			    </div>
			    <button type="submit" class="btn btn-primary">{{ trans('home.Save') }}</button>
			{{ Form::token() }}
			{{ Form::close() }}
		</div>
	</div>
@stop